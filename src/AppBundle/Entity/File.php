<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FileRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class File
{
    /**
     * @var int
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
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=255)
     */
    private $hash;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modification", type="datetime")
     */
    private $lastModification;

    /**
     * @ORM\ManyToOne(targetEntity="Directory", inversedBy="files")
     * @ORM\JoinColumn(name="directory_id", referencedColumnName="id")
     */
    private $directory;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return File
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
     * Set hash
     *
     * @param string $hash
     *
     * @return File
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set lastModification
     *
     * @param \DateTime $lastModification
     *
     * @return File
     */
    public function setLastModification($lastModification)
    {
        $this->lastModification = $lastModification;

        return $this;
    }

    /**
     * Get lastModification
     *
     * @return \DateTime
     */
    public function getLastModification()
    {
        return $this->lastModification;
    }

    /**
     * Set directory
     *
     * @param \AppBundle\Entity\Directory $directory
     *
     * @return File
     */
    public function setDirectory(\AppBundle\Entity\Directory $directory = null)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * Get directory
     *
     * @return \AppBundle\Entity\Directory
     */
    public function getDirectory()
    {
        return $this->directory;
    }


    /**
     * Set size
     *
     * @param integer $size
     *
     * @return File
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setCreatedAtValue()
    {
        $this->lastModification = new \DateTime();
    }
}
