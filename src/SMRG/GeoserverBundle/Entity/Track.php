<?php

namespace SMRG\GeoserverBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Track
 */
class Track
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
     * @var integer
     */
    private $rating;

    /**
     * @var string
     */
    private $gpxfile;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @var \SMRG\GeoserverBundle\Entity\Project
     */
    private $project;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $events;

    private $file;
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pictures;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
        $this->attributes = array();
    }

    /**
     * @param mixed $file
     */
    public function hasFile()
    {
        return isset($this->file) ? true : false;
    }

    /**
     * @param mixed $file
     */
    public function isFile($file)
    {
        return true;

    }

    public function addFile($file)
    {
        move_uploaded_file($file, '/var/www/');
    }

    public function removeFile($file)
    {
        $this->file = null;
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
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     * @return Track
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    public function getGpxfile()
    {
        return $this->gpxfile;
    }

    public function setGpxfile($gpxfile)
    {
        $this->gpxfile = $gpxfile;
    }

    /**
     * Get attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set attributes
     *
     * @param array $attributes
     * @return Track
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function removeAttribute($key)
    {
        if (array_key_exists($this->attributes[$key])) {
            unset($this->attributes[$key]);
        }

        return false;

    }

    /**
     * Get project
     *
     * @return \SMRG\GeoserverBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set project
     *
     * @param \SMRG\GeoserverBundle\Entity\Project $project
     * @return Track
     */
    public function setProject(\SMRG\GeoserverBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Add events
     *
     * @param \SMRG\GeoserverBundle\Entity\EventCategory $events
     * @return Track
     */
    public function addEvent(\SMRG\GeoserverBundle\Entity\EventCategory $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \SMRG\GeoserverBundle\Entity\EventCategory $events
     */
    public function removeEvent(\SMRG\GeoserverBundle\Entity\EventCategory $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    public function __toString()
    {
        return $this->getName();
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
     * @return Track
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getAbsolutePath()
    {
        return null === $this->gpxfile ? null : $this->getUploadRootDir() . '/' . $this->gpxfile;
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/tracks';
    }

    public function getWebPath()
    {
        return null === $this->gpxfile ? null : $this->getUploadDir() . '/' . $this->gpxfile;
    }

    public function upload()
    {

        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        $this->gpxfile = $this->getFile()->getClientOriginalName();
        $this->file = null;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Add pictures
     *
     * @param \SMRG\GeoserverBundle\Entity\TrackPicture $pictures
     * @return Track
     */
    public function addPicture(\SMRG\GeoserverBundle\Entity\TrackPicture $pictures)
    {
        $this->pictures[] = $pictures;

        return $this;
    }

    /**
     * Remove pictures
     *
     * @param \SMRG\GeoserverBundle\Entity\TrackPicture $pictures
     */
    public function removePicture(\SMRG\GeoserverBundle\Entity\TrackPicture $pictures)
    {
        $this->pictures->removeElement($pictures);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }
}
