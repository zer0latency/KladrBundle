<?php

namespace zer0latency\KladrBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use zer0latency\KladrBundle\Entity\BaseEntity;

/**
 * Altnames
 *
 * @ORM\Table(name="kladr_altnames")
 * @ORM\Entity(repositoryClass="zer0latency\KladrBundle\Entity\AltnamesRepository")
 */
class Altnames extends BaseEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="oldcode", type="string", length=30)
     */
    protected $oldcode;

    /**
     * @var string
     *
     * @ORM\Column(name="newcode", type="string", length=30)
     */
    protected $newcode;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    protected $level;


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
     * @param integer $level
     * @return Altnames
     */
    public function setLevel($level)
    {
        $this->level = (int) $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }
}
