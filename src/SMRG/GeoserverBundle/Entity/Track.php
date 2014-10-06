<?php

namespace SMRG\GeoserverBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    private $file;
    /**
     * @var \SMRG\GeoserverBundle\Entity\Project
     */
    private $project;

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
     * @return Track
     */
    public function setName($name)
    {
        $this->name = $name;

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

    public function getAbsolutePath()
    {
        return null === $this->gpxfile
            ? null
            : $this->getUploadRootDir() . '/' . $this->gpxfile;
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
        return null === $this->gpxfile
            ? null
            : $this->getUploadDir() . '/' . $this->gpxfile;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->gpxfile = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }








}
