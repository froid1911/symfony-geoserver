<?php

namespace SMRG\GeoserverBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrackPicture
 */
class TrackPicture
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
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $path;

    /**
     * File
     */
    private $file;
    /**
     * @var \SMRG\GeoserverBundle\Entity\Track
     */
    private $track;

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
     * @return TrackPicture
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return TrackPicture
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return TrackPicture
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/images';
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
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

        $this->path = $this->getFile()->getClientOriginalName();
        $this->file = null;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
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
     * @return TrackPicture
     */
    public function setTrack(\SMRG\GeoserverBundle\Entity\Track $track = null)
    {
        $this->track = $track;

        return $this;
    }
}
