<?php

namespace SMRG\GeoserverBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 */
class Project
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tracks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tracks = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add tracks
     *
     * @param \SMRG\GeoserverBundle\Entity\Track $tracks
     * @return Project
     */
    public function addTrack(\SMRG\GeoserverBundle\Entity\Track $tracks)
    {
        $this->tracks[] = $tracks;

        return $this;
    }

    /**
     * Remove tracks
     *
     * @param \SMRG\GeoserverBundle\Entity\Track $tracks
     */
    public function removeTrack(\SMRG\GeoserverBundle\Entity\Track $tracks)
    {
        $this->tracks->removeElement($tracks);
    }

    /**
     * Get tracks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    public function __toString()
    {
        return $this->name;
    }
}
