<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * DateEventGroup.
 *
 * @ORM\Table(name="date_event_group")
 * @ORM\Entity
 */
class DateEventGroup
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="DateEvent", mappedBy="dateEventGroup")
     */
    private $dateEvents;

    public function __construct()
    {
        $this->dateEvents = new ArrayCollection();
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->dateEvents->first()->getOwner();
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->dateEvents->first()->getType();
    }

    /**
     * @return string
     */
    public function getEmailType()
    {
        return $this->dateEvents->first()->getEmailType();
    }

    /**
     * @return DateEvent|null
     */
    public function getStart()
    {
        /* @var DateEvent $start */
        $date = null;

        /** @var DateEvent $dateEvent */
        foreach ($this->dateEvents as $dateEvent) {
            if ($date === null || $dateEvent->getStart() < $date->getStart()) {
                $date = $dateEvent;
            }
        }

        return $date->getStart();
    }

    /**
     * @return DateEvent|null
     */
    public function getEnd()
    {
        /* @var DateEvent $start */
        $date = null;

        /** @var DateEvent $dateEvent */
        foreach ($this->dateEvents as $dateEvent) {
            if ($date === null || $dateEvent->getEnd() > $date->getEnd()) {
                $date = $dateEvent;
            }
        }

        return $date->getEnd();
    }

    /**
     * @return int
     */
    public function getEventCount()
    {
        return $this->dateEvents->count();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getDateEvents()
    {
        return $this->dateEvents;
    }

    /**
     * @param ArrayCollection $dateEvents
     *
     * @return DateEventGroup
     */
    public function setDateEvents($dateEvents)
    {
        $this->dateEvents = $dateEvents;

        return $this;
    }

    /**
     * @param DateEvent $dateEvent
     *
     * @return DateEventGroup
     */
    public function addDateEvent(DateEvent $dateEvent)
    {
        if (!$this->dateEvents->contains($dateEvent)) {
            $this->dateEvents->add($dateEvent);
        }

        return $this;
    }

    /**
     * @param DateEvent $dateEvent
     *
     * @return DateEventGroup
     */
    public function removeDateEvent(DateEvent $dateEvent)
    {
        $this->dateEvents->removeElement($dateEvent);

        return $this;
    }
}
