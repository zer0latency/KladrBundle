<?php

namespace zer0latency\KladrBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Altnames
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="zer0latency\KladrBundle\Entity\AltnamesRepository")
 */
class Altnames
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
     * @var string
     *
     * @ORM\Column(name="oldcode", type="string", length=30)
     */
    private $oldcode;

    /**
     * @var string
     *
     * @ORM\Column(name="newcode", type="string", length=30)
     */
    private $newcode;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="int", length=11)
     */
    private $level;


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
     * Set oldcode
     *
     * @param string $oldcode
     * @return Altnames
     */
    public function setOldcode($oldcode)
    {
        $this->oldcode = $oldcode;

        return $this;
    }

    /**
     * Get oldcode
     *
     * @return string 
     */
    public function getOldcode()
    {
        return $this->oldcode;
    }

    /**
     * Set newcode
     *
     * @param string $newcode
     * @return Altnames
     */
    public function setNewcode($newcode)
    {
        $this->newcode = $newcode;

        return $this;
    }

    /**
     * Get newcode
     *
     * @return string 
     */
    public function getNewcode()
    {
        return $this->newcode;
    }

    /**
     * Set level
     *
     * @param \int $level
     * @return Altnames
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
}
