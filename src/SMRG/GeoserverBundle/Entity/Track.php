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
     * @return Track
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

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
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
     * @var \SMRG\GeoserverBundle\Entity\Project
     */
    private $project;


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
     * Get project
     *
     * @return \SMRG\GeoserverBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }
}
