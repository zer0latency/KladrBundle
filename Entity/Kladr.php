<?php

namespace zer0latency\KladrBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kladr
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="zer0latency\KladrBundle\Entity\KladrRepository")
 */
class Kladr
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="socr", type="string", length=255)
     */
    private $socr;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=30)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="post_index", type="string", length=6)
     */
    private $postIndex;

    /**
     * @var string
     *
     * @ORM\Column(name="gninmb", type="string", length=10)
     */
    private $gninmb;

    /**
     * @var string
     *
     * @ORM\Column(name="ocatd", type="string", length=20)
     */
    private $ocatd;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10)
     */
    private $status;


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
}
