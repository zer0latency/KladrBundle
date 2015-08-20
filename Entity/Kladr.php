<?php

namespace zer0latency\KladrBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use zer0latency\KladrBundle\Entity\BaseEntity;

/**
 * Kladr
 *
 * @ORM\Table(name="kladr_kladr")
 * @ORM\Entity(repositoryClass="zer0latency\KladrBundle\Entity\KladrRepository")
 */
class Kladr extends BaseEntity
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
     * @ORM\Column(name="ocatd", type="string", length=20)
     */
    protected $ocatd;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10)
     */
    protected $status;


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
     * @return Kladr
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
     * Set socr
     *
     * @param string $socr
     * @return Kladr
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
     * @return Kladr
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
     * @return Kladr
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
     * @return Kladr
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
     * Set ocatd
     *
     * @param string $ocatd
     * @return Kladr
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
     * Set status
     *
     * @param string $status
     * @return Kladr
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Build entity from array
     *
     * @param array $values
     *
     * @return \zer0latency\KladrBundle\Entity\Kladr
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
