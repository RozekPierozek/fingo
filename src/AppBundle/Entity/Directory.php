<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Directory
 *
 * @ORM\Table(name="directory")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DirectoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Directory
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
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modification", type="datetime")
     */
    private $lastModification;

    /**
     * @ORM\OneToMany(targetEntity="Directory", mappedBy="parent")
     */
    private $subDirectores;

    /**
     * @ORM\ManyToOne(targetEntity="Directory", inversedBy="subDirectores")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="File", mappedBy="directory")
     */
    private $files;

    public function __construct()
    {
        $this->subDirectores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * @return Directory
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
     * Set lastModification
     *
     * @param \DateTime $lastModification
     *
     * @return Directory
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
     * Add subDirectore
     *
     * @param \AppBundle\Entity\Directory $subDirectore
     *
     * @return Directory
     */
    public function addSubDirectore(\AppBundle\Entity\Directory $subDirectore)
    {
        $this->subDirectores[] = $subDirectore;

        return $this;
    }

    /**
     * Remove subDirectore
     *
     * @param \AppBundle\Entity\Directory $subDirectore
     */
    public function removeSubDirectore(\AppBundle\Entity\Directory $subDirectore)
    {
        $this->subDirectores->removeElement($subDirectore);
    }

    /**
     * Get subDirectores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubDirectores()
    {
        return $this->subDirectores;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\Directory $parent
     *
     * @return Directory
     */
    public function setParent(\AppBundle\Entity\Directory $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Directory
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add file
     *
     * @param \AppBundle\Entity\File $file
     *
     * @return Directory
     */
    public function addFile(\AppBundle\Entity\File $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \AppBundle\Entity\File $file
     */
    public function removeFile(\AppBundle\Entity\File $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setCreatedAtValue()
    {
        $this->lastModification = new \DateTime();
    }

    public function __toString() {
        return $this->name;
    }
}
