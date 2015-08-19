<?php

namespace zer0latency\KladrBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Socrbase
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="zer0latency\KladrBundle\Entity\SocrbaseRepository")
 */
class Socrbase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="int", length=11)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="scname", type="string", length=255)
     */
    private $scname;

    /**
     * @var string
     *
     * @ORM\Column(name="socrname", type="string", length=255)
     */
    private $socrname;

    /**
     * @var int
     *
     * @ORM\Column(name="kod_t_st", type="int", length=11)
     */
    private $kod_t_st;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set level
     *
     * @param \int $level
     * @return Socrbase
     */
    public function setLevel(\int $level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \int 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set scname
     *
     * @param string $scname
     * @return Socrbase
     */
    public function setScname($scname)
    {
        $this->scname = $scname;

        return $this;
    }

    /**
     * Get scname
     *
     * @return string 
     */
    public function getScname()
    {
        return $this->scname;
    }

    /**
     * Set socrname
     *
     * @param string $socrname
     * @return Socrbase
     */
    public function setSocrname($socrname)
    {
        $this->socrname = $socrname;

        return $this;
    }

    /**
     * Get socrname
     *
     * @return string 
     */
    public function getSocrname()
    {
        return $this->socrname;
    }

    /**
     * Set kod_t_st
     *
     * @param \int $kodTSt
     * @return Socrbase
     */
    public function setKodTSt(\int $kodTSt)
    {
        $this->kod_t_st = $kodTSt;

        return $this;
    }

    /**
     * Get kod_t_st
     *
     * @return \int 
     */
    public function getKodTSt()
    {
        return $this->kod_t_st;
    }
}
