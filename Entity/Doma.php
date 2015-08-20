<?php

namespace zer0latency\KladrBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use zer0latency\KladrBundle\Entity\BaseEntity;

/**
 * Doma
 *
 * @ORM\Table(name="kladr_doma")
 * @ORM\Entity(repositoryClass="zer0latency\KladrBundle\Entity\DomaRepository")
 */
class Doma extends BaseEntity
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="korp", type="string", length=255)
     */
    protected $korp;

    /**
     * @var string
     *
     * @ORM\Column(name="socr", type="string", length=255)
     */
    protected $socr;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=30)
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(name="post_index", type="string", length=6)
     */
    protected $postIndex;

    /**
     * @var string
     *
     * @ORM\Column(name="gninmb", type="string", length=10)
     */
    protected $gninmb;

    /**
     * @var string
     *
     * @ORM\Column(name="uno", type="string", length=10)
     */
    protected $uno;

    /**
     * @var string
     *
     * @ORM\Column(name="ocatd", type="string", length=20)
     */
    protected $ocatd;


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
     * Set name
     *
     * @param string $name
     * @return Doma
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set korp
     *
     * @param string $korp
     * @return Doma
     */
    public function setKorp($korp)
    {
        $this->korp = $korp;

        return $this;
    }

    /**
     * Get korp
     *
     * @return string
     */
    public function getKorp()
    {
        return $this->korp;
    }

    /**
     * Set socr
     *
     * @param string $socr
     * @return Doma
     */
    public function setSocr($socr)
    {
        $this->socr = $socr;

        return $this;
    }

    /**
     * Get socr
     *
     * @return string
     */
    public function getSocr()
    {
        return $this->socr;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Doma
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set postIndex
     *
     * @param string $postIndex
     * @return Doma
     */
    public function setPostIndex($postIndex)
    {
        $this->postIndex = $postIndex;

        return $this;
    }

    /**
     * Get postIndex
     *
     * @return string
     */
    public function getPostIndex()
    {
        return $this->postIndex;
    }

    /**
     * Set gninmb
     *
     * @param string $gninmb
     * @return Doma
     */
    public function setGninmb($gninmb)
    {
        $this->gninmb = $gninmb;

        return $this;
    }

    /**
     * Get gninmb
     *
     * @return string
     */
    public function getGninmb()
    {
        return $this->gninmb;
    }

    /**
     * Set uno
     *
     * @param string $uno
     * @return Doma
     */
    public function setUno($uno)
    {
        $this->uno = $uno;

        return $this;
    }

    /**
     * Get uno
     *
     * @return string
     */
    public function getUno()
    {
        return $this->uno;
    }

    /**
     * Set ocatd
     *
     * @param string $ocatd
     * @return Doma
     */
    public function setOcatd($ocatd)
    {
        $this->ocatd = $ocatd;

        return $this;
    }

    /**
     * Get ocatd
     *
     * @return string
     */
    public function getOcatd()
    {
        return $this->ocatd;
    }

    /**
     * Build entity from array
     *
     * @param array $values
     *
     * @return \zer0latency\KladrBundle\Entity\Doma
     */
    public function deserialize($values)
    {
        foreach ($values as $name => $value) {
            $name = strtolower($name);
            if ( !isset($this->$name) ) {
                continue;
            }
            $methodName = "set".ucfirst($name);
            $this->$methodName($value);
        }

        return $this;
    }
}
