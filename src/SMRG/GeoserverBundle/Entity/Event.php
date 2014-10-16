<?php

namespace SMRG\GeoserverBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 */
class Event
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var \SMRG\GeoserverBundle\Entity\Track
     */
    private $track;
    /**
     * @var float
     */
    private $latitude;
    /**
     * @var float
     */
    private $longitude;
    /**
     * @var string
     */
    private $description;

    /**
     * @var
     */
    /**
     * @var \SMRG\GeoserverBundle\Entity\EventCategory
     */
    private $category;
    /**
     * @var \SMRG\GeoserverBundle\Entity\Track
     */
    private $tracks;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Get track
     *
     * @return \SMRG\GeoserverBundle\Entity\Track
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * Set track
     *
     * @param \SMRG\GeoserverBundle\Entity\Track $track
     * @return Event
     */
    public function setTrack(\SMRG\GeoserverBundle\Entity\Track $track = null)
    {
        $this->track = $track;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Event
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Event
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get category
     *
     * @return \SMRG\GeoserverBundle\Entity\EventCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param \SMRG\GeoserverBundle\Entity\EventCategory $category
     * @return Event
     */
    public function setCategory(\SMRG\GeoserverBundle\Entity\EventCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    public function __toString()
    {
        return $this->getId();
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
     * Get tracks
     *
     * @return \SMRG\GeoserverBundle\Entity\Track
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * Set tracks
     *
     * @param \SMRG\GeoserverBundle\Entity\Track $tracks
     * @return Event
     */
    public function setTracks(\SMRG\GeoserverBundle\Entity\Track $tracks = null)
    {
        $this->tracks = $tracks;

        return $this;
    }
}
