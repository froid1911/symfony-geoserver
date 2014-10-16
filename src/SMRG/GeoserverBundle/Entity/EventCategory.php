<?php

namespace SMRG\GeoserverBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventCategory
 */
class EventCategory
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
    private $icon;
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $events;
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categoryevents;

    /**
     * Constructor
     */
    public function __construct()
    {

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
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return EventCategory
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Add events
     *
     * @param \SMRG\GeoserverBundle\Entity\Event $events
     * @return EventCategory
     */
    public function addEvent(\SMRG\GeoserverBundle\Entity\Event $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \SMRG\GeoserverBundle\Entity\Event $events
     */
    public function removeEvent(\SMRG\GeoserverBundle\Entity\Event $events)
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

    /**
     * Add categoryevents
     *
     * @param \SMRG\GeoserverBundle\Entity\Event $categoryevents
     * @return EventCategory
     */
    public function addCategoryevent(\SMRG\GeoserverBundle\Entity\Event $categoryevents)
    {
        $this->categoryevents[] = $categoryevents;

        return $this;
    }

    /**
     * Remove categoryevents
     *
     * @param \SMRG\GeoserverBundle\Entity\Event $categoryevents
     */
    public function removeCategoryevent(\SMRG\GeoserverBundle\Entity\Event $categoryevents)
    {
        $this->categoryevents->removeElement($categoryevents);
    }

    /**
     * Get categoryevents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoryevents()
    {
        return $this->categoryevents;
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
     * @return EventCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
