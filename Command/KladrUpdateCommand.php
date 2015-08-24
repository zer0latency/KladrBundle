<?php
namespace zer0latency\KladrBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManager;

class KladrUpdateCommand extends ContainerAwareCommand
{
    private static $defaultKladrSource = 'http://www.gnivc.ru/html/gnivcsoft/KLADR/Base.7z';

    /**
     * Output Interface
     *
     * @var OutputInterface
     */
    private $output;

    /**
     * Entity Manager
     *
     * @var EntityManager
     */
    private $em;

    /**
     * Do not delete (DBF files)
     *
     * @var boolean
     */
    private $dnd;

    /**
     * Operations before $em->flush()  (must be reduced on low RAM machines or enlarged on high RAM)
     *
     * @var int
     */
    private $batchLimit = 100000;

    protected function configure()
    {
        $this
            ->setName('kladr:update')
            ->setDescription('Download and update kladr database')
            ->addOption(
                'file',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, process this archive, do not download'
            )
            ->addOption(
                'directory',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, search DBF files in that directory'
            )
            ->addOption(
                'dnd',
                null,
                InputOption::VALUE_OPTIONAL,
                'Do not delete DBF files after processing'
            )
            ->addOption(
                'batchLimit',
                null,
                InputOption::VALUE_OPTIONAL,
                'Operations before $em->flush() (must be reduced on low RAM machines or enlarged on high RAM)'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->em     = $this->getContainer()->get('doctrine.orm.entity_manager');
        $this->dnd    = $input->getOption('dnd') ? true : false;
        $this->batchLimit = $input->getOption('batchLimit') ? $input->getOption('batchLimit') : $this->batchLimit;

        $archive   = $input->getOption('file');
        $directory = $input->getOption('directory');

        if ( !$archive && !$directory ) {
            $archive = $this->downloadArchive();
        }

        if ( $directory ) {
            $files = $this->processDirectory($directory);
        } else {
            $files = $this->unpackArchive($archive);
        }

        $this->importTables($files);
    }

    /**
     * Import DBF files into database
     *
     * @param array $filenames
     */
    protected function importTables($filenames)
    {
        foreach ($filenames as $entity => $filename) {
            try {
                $this->output->writeln("Entity: $entity, File: $filename");
                $this->importDbf("KladrBundle:$entity", $filename);
            } catch (\Doctrine\Common\Persistence\Mapping\MappingException $e) {
                $this->output->writeln("    Skipping table: $filename");
                if ( !$this->dnd ) {
                    unlink($filename);
                }
            }
        }
    }

    /**
     * Import DBASE file into entity's mysql table
     *
     * @param string $entity_name
     * @param string $filename
     *
     * @throws \Exception
     */
    protected function importDbf($entity_name, $filename)
    {
        if ( !function_exists('dbase_open') ) {
            throw new \Exception("This bundle requires dbase PHP extension. Try to install it with 'pecl install dbase'.");
        }

        $this->truncateTable($entity_name);

        $db = dbase_open($filename, 0); // Reading mode
        if ( !$db ) {
            throw new \Exception("Could not open dbase: $filename");
        }

        $records_count     = dbase_numrecords($db);
        $progress_stepsize = floor($records_count / 10);

        $tmpcsvname = sys_get_temp_dir().DIRECTORY_SEPARATOR.basename("$filename.csv");
        $tempcsv = fopen($tmpcsvname, "w+");

        $this->output->writeln("Records: <info>$records_count</info>, stepsize: <info>$progress_stepsize</info>");
        $start_time = microtime(true);
        $headers = array();
        for ($i = 1; $i <= $records_count; $i++) {
            $row = dbase_get_record_with_names($db, $i);
            if ($i === 1) {
                foreach($row as $field => $value) {
                    $field = $field === 'INDEX' ? 'post_index' : strtolower($field);
                    $headers[] = strtolower($field);
                }
                fputcsv($tempcsv, $headers, ';');
            }
            foreach ($row as $field => $value) {
                $row[$field] = (gettype($value) === "string")
                             ? trim(iconv('cp866','utf8',$value))
                             : $value;
            }
            fputcsv($tempcsv, $row, ';');
            if ( $i % $progress_stepsize === 0) {
                $this->output->write('#');
            }
        }
        fclose($tempcsv);
        chmod($tmpcsvname, 0777);
        $this->importCsv($entity_name, $tmpcsvname, $headers);
        $this->output->writeln(
            sprintf("  Operation taked: <info>%u</info> seconds.", microtime(true)-$start_time)
        );
        $this->output->writeln("  Done!");

        if ( !$this->dnd ) {
            unlink($filename);
            unlink($tmpcsvname);
        }
    }

    /**
     * Truncate table
     *
     * @param string $entity
     *
     * @return boolean
     */
    protected function truncateTable($entity)
    {
        $table = $this->em->getClassMetadata($entity)->getTableName();
        $sql   = "TRUNCATE TABLE $table";
        $stmt  = $this->em->getConnection()->prepare($sql);

        return $stmt->execute();
    }

    /**
     * Import CSV file with LOAD DATA INFILE command
     *
     * @param string $entity
     * @param string $file
     * @param array  $fields
     *
     * @return boolean
     */
    protected function importCsv($entity, $file, $fields = '')
    {
        if ( !empty($fields) ) {
            $fields = array_intersect($fields, $this->em->getClassMetadata($entity)->columnNames);
            $fields = sprintf("(%s)", implode(', ', $fields));
        }
        $fullpath = realpath($file);
        $table = $this->em->getClassMetadata($entity)->getTableName();
        $sql = "LOAD DATA INFILE '$fullpath' INTO TABLE $table FIELDS TERMINATED BY 0x3b IGNORE 1 LINES $fields;";
        $stmt = $this->em->getConnection()->prepare($sql);

        return $stmt->execute();

    }

    /**
     * Process directory with DBF files, not archive
     *
     * @param string $directory
     *
     * @return array
     */
    protected function processDirectory($directory)
    {
        $files = glob($directory . DIRECTORY_SEPARATOR . '*.DBF');
        $return_array = array();

        foreach ($files as $file) {
            $return_array[ucfirst(basename(strtolower($file), ".dbf"))] = $file;
        }

        return $return_array;
    }

    /**
     * Extract files from 7z archive
     *
     * @param string $archive
     *
     * @return array An array with files names extracted
     *
     * @throws \Exception
     */
    protected function unpackArchive($archive)
    {
        $output = array();
        $extracted_files = array();

        $return_var = 0;
        exec(
            sprintf("p7zip -d %s", $archive),
            $output,
            $return_var
        );

        if ( $return_var != 0 ) {
            throw new \Exception("Unable to extract archive: $archive");
        }

        foreach ($output as $line) {
            if ( strpos($line, 'Extracting  ') === false ) {
                continue;
            }

            $filename                      = explode('  ', $line)[1];
            $entity_name                   = ucfirst(strtolower(basename($filename, '.DBF')));
            $extracted_files[$entity_name] = $filename;
        }

        if ( count($extracted_files) === 0) {
            throw new \Exception("There is no files in archive: $archive");
        }

        return $extracted_files;
    }

    /**
     * Download kladr source archive
     *
     * @return string Downloaded file path
     *
     * @throws \Exception
     */
    protected function downloadArchive()
    {
        $source = self::$defaultKladrSource;
        $destination = tempnam(sys_get_temp_dir(), 'kladr_') . '.7z';
        $file_handler = fopen($destination, 'w+');

        // Download file
        $source_content = file_get_contents($source);
        if ( !$source_content ) {
            throw new \Exception("Could not read source file: $source");
        }

        // Write file to disk
        $write_result = fwrite($file_handler, $source_content);
        if ( !$write_result ) {
            throw new \Exception("Could not write file: $destination");
        }

        // Close the file
        fclose($file_handler);

        return $destination;
    }
}