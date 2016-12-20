<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="date_event")
 */
class DateEvent
{
    const TYPE_PTO = 'PTO';
    const TYPE_UPTO = 'UPTO';
    const TYPE_WFH = 'WFH';
    const TYPE_FLEX = 'FLEX';
    const TYPE_EXCEPTION = 'Exception';

    const NAME_PTO = 'Planned Time Off';
    const NAME_UPTO = 'Unplanned Time Off';
    const NAME_WFH = 'Work From Home';
    const NAME_FLEX = 'Flex';
    const NAME_EXCEPTION = 'Exception';

    const STATUS_APPROVED = 'Approved';
    const STATUS_PENDING = 'Awaiting Approval';
    const STATUS_DENIED = 'Denied';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var EventType
     *
     * @ORM\ManyToOne(targetEntity="EventType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime")
     */
    protected $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime")
     */
    protected $end;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="status_reason", type="string", length=255, nullable=true)
     */
    protected $statusReason;

    /**
     * @var string
     *
     * @ORM\Column(name="reason_requested", type="text")
     */
    protected $reasonRequested;

    /**
     * @var string
     *
     * @ORM\Column(name="jira_id", type="string", length=50, nullable=true)
     */
    private $jiraId;

    /**
     * @var string
     *
     * @ORM\Column(name="jira_key", type="string", length=50, nullable=true)
     */
    private $jiraKey;

    /**
     * @var bool
     *
     * @ORM\Column(name="planned", type="boolean", nullable=true)
     */
    private $planned;

    /**
     * @var bool
     *
     * @ORM\Column(name="track_in_jira", type="boolean", nullable=true, options={"default" = true})
     */
    private $trackedInJira;

    /**
     * @var bool
     *
     * @ORM\Column(name="track_in_wtf", type="boolean", nullable=true, options={"default" = true})
     */
    private $trackedInWTF;

    /**
     * @var string
     *
     * @ORM\Column(name="google_calendar_id", type="string", length=255, nullable=true)
     */
    private $calendarId;

    /**
     * @var string
     *
     * @ORM\Column(name="google_calendar_event_id", type="string", length=255, nullable=true)
     */
    private $calendarEventId;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="dateEvents")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="AdminNote", mappedBy="dateEvent", cascade={"persist", "remove"})
     */
    protected $adminNotes;

    /**
     * @var DateEventGroup
     *
     * @ORM\ManyToOne(targetEntity="DateEventGroup", inversedBy="dateEvents", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="date_event_group_id", referencedColumnName="id")
     */
    private $dateEventGroup;

    public function __construct()
    {
        $this->adminNotes = new ArrayCollection();
        $this->trackedInJira = true;
        $this->trackedInWTF = true;
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
     * @return bool
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isDenied()
    {
        return $this->status === self::STATUS_DENIED;
    }

    public function getHoursRequested()
    {
        return $this->end->diff($this->start)->h;
    }

    /**
     * @return bool
     */
    public function getPlanned()
    {
        return $this->planned;
    }

    /**
     * @param bool $planned
     *
     * @return DateEvent
     */
    public function setPlanned($planned)
    {
        $this->planned = $planned;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailType()
    {
//        switch ($this->type->getCode()) {
//            case self::TYPE_UPTO:
//            case self::TYPE_PTO:
//                return EmailService::TYPE_PTO;
//            case self::TYPE_FLEX:
//                return EmailService::TYPE_FLEX;
//            case self::TYPE_WFH:
//                return EmailService::TYPE_WFH;
//            case self::TYPE_EXCEPTION:
//                return EmailService::TYPE_EXCEPTION;
//        }
    }

    /**
     * @return EventType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param EventType $type
     *
     * @return DateEvent
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \DateTime $start
     *
     * @return DateEvent
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     *
     * @return DateEvent
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return DateEvent
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatusReason()
    {
        return $this->statusReason;
    }

    /**
     * @param string $statusReason
     *
     * @return DateEvent
     */
    public function setStatusReason($statusReason)
    {
        $this->statusReason = $statusReason;

        return $this;
    }

    /**
     * @return string
     */
    public function getReasonRequested()
    {
        return $this->reasonRequested;
    }

    /**
     * @param string $reasonRequested
     *
     * @return DateEvent
     */
    public function setReasonRequested($reasonRequested)
    {
        $this->reasonRequested = $reasonRequested;

        return $this;
    }

    /**
     * @return string
     */
    public function getJiraId()
    {
        return $this->jiraId;
    }

    /**
     * @param string $jiraId
     *
     * @return DateEvent
     */
    public function setJiraId($jiraId)
    {
        $this->jiraId = $jiraId;

        return $this;
    }

    /**
     * @return string
     */
    public function getJiraKey()
    {
        return $this->jiraKey;
    }

    /**
     * @param string $jiraKey
     *
     * @return DateEvent
     */
    public function setJiraKey($jiraKey)
    {
        $this->jiraKey = $jiraKey;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTrackedInJira()
    {
        return $this->trackedInJira;
    }

    /**
     * @param bool $trackedInJira
     *
     * @return DateEvent
     */
    public function setTrackedInJira($trackedInJira)
    {
        $this->trackedInJira = $trackedInJira;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTrackedInWTF()
    {
        return $this->trackedInWTF;
    }

    /**
     * @param bool $trackedInWTF
     *
     * @return DateEvent
     */
    public function setTrackedInWTF($trackedInWTF)
    {
        $this->trackedInWTF = $trackedInWTF;

        return $this;
    }

    /**
     * @return string
     */
    public function getCalendarId()
    {
        return $this->calendarId;
    }

    /**
     * @param string $calendarId
     *
     * @return DateEvent
     */
    public function setCalendarId($calendarId)
    {
        $this->calendarId = $calendarId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCalendarEventId()
    {
        return $this->calendarEventId;
    }

    /**
     * @param string $calendarEventId
     *
     * @return DateEvent
     */
    public function setCalendarEventId($calendarEventId)
    {
        $this->calendarEventId = $calendarEventId;

        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     *
     * @return DateEvent
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return string
     */
    public function getAdminNotes()
    {
        return $this->adminNotes;
    }

    /**
     * @param string $adminNotes
     *
     * @return DateEvent
     */
    public function setAdminNotes($adminNotes)
    {
        $this->adminNotes = $adminNotes;

        return $this;
    }

    /**
     * @param $adminNote
     *
     * @return $this
     */
    public function addAdminNotes($adminNote)
    {
        if (!$this->adminNotes->contains($adminNote)) {
            $this->adminNotes->add($adminNote);
        }

        return $this;
    }

    /**
     * @param $adminNote
     *
     * @return $this
     */
    public function removeAdminNotes($adminNote)
    {
        $this->adminNotes->removeElement($adminNote);

        return $this;
    }

    /**
     * @return bool
     */
    public function hasJiraKey()
    {
        return $this->jiraKey !== '';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->id) {
            return (string) $this->id;
        }

        return '';
    }

    /**
     * @return DateEventGroup
     */
    public function getDateEventGroup()
    {
        return $this->dateEventGroup;
    }

    /**
     * @param DateEventGroup $dateEventGroup
     *
     * @return DateEvent
     */
    public function setDateEventGroup($dateEventGroup)
    {
        $this->dateEventGroup = $dateEventGroup;

        return $this;
    }

    /**
     * @param DateEvent $object
     *
     * @return string
     */
    public static function getCleanClassName(DateEvent $object)
    {
        switch ($object->getType()) {
            case self::TYPE_PTO:
                return self::NAME_PTO;
            case self::TYPE_UPTO:
                return self::NAME_UPTO;
            case self::TYPE_WFH:
                return self::NAME_WFH;
            case self::TYPE_FLEX:
                return self::NAME_FLEX;
            case self::TYPE_EXCEPTION:
                return self::NAME_EXCEPTION;
        }
    }
}
