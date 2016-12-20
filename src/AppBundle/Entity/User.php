<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User.
 *
 * @ApiResource
 * @ORM\Table(name="fos_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    const PTODAYS = 15;
    const PTOHOURSPERDAY = 8;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="jira_access_token", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    protected $jiraAccessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="jira_token_secret", type="string", length=255, nullable=true)
     */
    protected $jiraTokenSecret;

    /**
     * @var string
     *
     * @ORM\Column(name="jira_refresh_token", type="string", length=255, nullable=true)
     */
    protected $jiraRefreshToken;

    /**
     * @var string
     *
     * @ORM\Column(name="jira_email", type="string", length=255)
     */
    private $jiraEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="hipchat_id", type="string", length=50, nullable=true)
     */
    private $hipchatId;

    /**
     * @var string
     *
     * @ORM\Column(name="display_name", type="string", length=255)
     */
    private $displayName;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="start_date", type="date")
     */
    private $startDate;

    /**
     * @var float
     *
     * @ORM\Column(name="pto_rate", type="float")
     */
    private $ptoRate = 1.25;

    /**
     * @var int
     *
     * @ORM\Column(name="flex_days", type="integer")
     */
    private $flexdays = 24;

    /**
     * @var int
     *
     * @ORM\Column(name="wfh_days", type="integer")
     */
    private $wfhdays = 24;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="DateEvent", mappedBy="owner", fetch="LAZY", orphanRemoval=true)
     */
    private $dateEvents;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Supplies", mappedBy="userRequested", fetch="LAZY", orphanRemoval=true)
     */
    private $suppliesRequested;

    /**
     * @var array
     *
     * @ORM\Column(name="email_subscriptions", type="array")
     */
    private $emailSubscriptions;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
     */
    private $googleEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="google_access_token", type="string", length=255, nullable=true)
     */
    private $googleAccessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="google_refresh_token", type="string", length=255, nullable=true)
     */
    private $googleRefreshToken;

    /**
     * @var HipchatConnectionRequest
     *
     * @ORM\OneToOne(targetEntity="HipchatConnectionRequest", mappedBy="user", orphanRemoval=true)
     */
    private $hipchatConnection;

    /**
     * @return string
     */
    public function getGoogleRefreshToken()
    {
        return $this->googleRefreshToken;
    }

    /**
     * @param string $googleRefreshToken
     *
     * @return User
     */
    public function setGoogleRefreshToken($googleRefreshToken)
    {
        $this->googleRefreshToken = $googleRefreshToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getGoogleEmail()
    {
        return $this->googleEmail;
    }

    /**
     * @param string $googleEmail
     *
     * @return User
     */
    public function setGoogleEmail($googleEmail)
    {
        $this->googleEmail = $googleEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getGoogleAccessToken($format = 'raw')
    {
        switch ($format) {
            case 'json':
                return json_encode(array('access_token' => $this->googleAccessToken));

            case 'raw':
            default:
                return $this->googleAccessToken;
        }
    }

    /**
     * @param string $googleAccessToken
     *
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->googleAccessToken = $googleAccessToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getJiraRefreshToken()
    {
        return $this->jiraRefreshToken;
    }

    /**
     * @param mixed $jiraRefreshToken
     *
     * @return User
     */
    public function setJiraRefreshToken($jiraRefreshToken)
    {
        $this->jiraRefreshToken = $jiraRefreshToken;

        return $this;
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
     * @return string
     */
    public function __toString()
    {
        if ($this->displayName) {
            return $this->displayName;
        } else {
            return $this->username;
        }
    }

    public function __construct()
    {
        parent::__construct();

        $this->dateEvents = new ArrayCollection();
        $this->suppliesRequested = new ArrayCollection();
        $this->emailSubscriptions = array();
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function hasEmailSubscription($type)
    {
        foreach ($this->emailSubscriptions as $emailSubscription) {
            if (strtoupper($emailSubscription) === strtoupper($type)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return ArrayCollection
     */
    public function getEmailSubscriptions()
    {
        return $this->emailSubscriptions;
    }

    /**
     * @param ArrayCollection $emailSubscriptions
     *
     * @return User
     */
    public function setEmailSubscriptions($emailSubscriptions)
    {
        $this->emailSubscriptions = $emailSubscriptions;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return mixed
     */
    public function addEmailSubscriptions($type)
    {
        if (!$this->emailSubscriptions->contains($type)) {
            $this->emailSubscriptions->add($type);
        }

        return $type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function removeEmailSubscriptions($type)
    {
        $this->emailSubscriptions->removeElement($type);

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName ? $this->displayName : $this->username;
    }

    /**
     * @param string $displayName
     *
     * @return User
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * @return string
     */
    public function getHipchatId()
    {
        return $this->hipchatId;
    }

    /**
     * @param string $hipchatId
     *
     * @return User
     */
    public function setHipchatId($hipchatId)
    {
        $this->hipchatId = $hipchatId;

        return $this;
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
     * @return $this
     */
    public function setDateEvents(ArrayCollection $dateEvents)
    {
        $this->dateEvents = $dateEvents;

        return $this;
    }

    /**
     * @param DateEvent $event
     *
     * @return $this
     */
    public function addDateEvent(DateEvent $event)
    {
        if (!$this->dateEvents->contains($event)) {
            $this->dateEvents->add($event);
        }

        return $this;
    }

    /**
     * @param DateEvent $event
     *
     * @return $this
     */
    public function removeDateEvents(DateEvent $event)
    {
        $this->dateEvents->removeElement($event);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSuppliesRequested()
    {
        return $this->suppliesRequested;
    }

    /**
     * @param ArrayCollection $supplies
     */
    public function setSuppliesRequested($supplies)
    {
        $this->suppliesRequested = $supplies;
    }

    /**
     * @param Supplies $supplies
     *
     * @return $this
     */
    public function addSuppliesRequested(Supplies $supplies)
    {
        if (!$this->suppliesRequested->contains($supplies)) {
            $this->suppliesRequested->add($supplies);
        }

        return $this;
    }

    /**
     * @param Supplies $supplies
     *
     * @return $this
     */
    public function removeSuppliesRequested(Supplies $supplies)
    {
        $this->suppliesRequested->removeElement($supplies);

        return $this;
    }

    /**
     * Set jiraId.
     *
     * @param string $jiraEmail
     *
     * @return User
     */
    public function setJiraEmail($jiraEmail)
    {
        $this->jiraEmail = $jiraEmail;

        return $this;
    }

    /**
     * Get jiraId.
     *
     * @return string
     */
    public function getJiraEmail()
    {
        return $this->jiraEmail;
    }

    /**
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     *
     * @return User
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return float
     */
    public function getPtoRate()
    {
        return $this->ptoRate;
    }

    /**
     * @param float $ptoRate
     */
    public function setPtoRate($ptoRate)
    {
        $this->ptoRate = $ptoRate;
    }

    /**
     * @return int
     */
    public function getFlexdays()
    {
        return $this->flexdays;
    }

    /**
     * @return int
     */
    public function getWfhDays()
    {
        return $this->wfhdays;
    }

    /**
     * @param int $flexdays
     */
    public function setFlexdays($flexdays)
    {
        $this->flexdays = $flexdays;
    }

    /**
     * @param int $wfhdays
     */
    public function setWfhdays($wfhdays)
    {
        $this->wfhdays = $wfhdays;
    }

    /**
     * @return int
     */
    public function getMonthsFromReset()
    {
        $d2 = new DateTime();

        return $d2->diff($this->getResetDate())->m;
    }

    /**
     * @return int
     */
    public function getPTOHoursFromReset()
    {
        $oneYearAgo = new DateTime();
        $oneYearAgo->modify('-1 year');

        if ($this->startDate > $oneYearAgo) {
            return ($this->getMonthsFromReset() + 1)  * $this->getPtoRate() * self::PTOHOURSPERDAY;
        } else {
            return self::PTODAYS * self::PTOHOURSPERDAY;
        }
    }

    /**
     * @return DateTime
     */
    public function getResetDate()
    {
        $startDate = $this->getStartDate();

        if ($startDate->diff(new DateTime())->y > 0) {
            $d = $startDate->format('d');
            $m = $startDate->format('m');
            $y = date('Y', time());

            $date = new DateTime("{$m}/{$d}/{$y}");
        } else {
            $date = $startDate;
        }
        if ($date < new DateTime('now')) {
            return $date;
        } else {
            return $date->modify('-1 year');
        }
    }

    /**
     * @return mixed
     */
    public function getJiraAccessToken()
    {
        return $this->jiraAccessToken;
    }

    /**
     * @param mixed $jiraAccessToken
     *
     * @return User
     */
    public function setJiraAccessToken($jiraAccessToken)
    {
        $this->jiraAccessToken = $jiraAccessToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getJiraTokenSecret()
    {
        return $this->jiraTokenSecret;
    }

    /**
     * @param mixed $jiraTokenSecret
     *
     * @return User
     */
    public function setJiraTokenSecret($jiraTokenSecret)
    {
        $this->jiraTokenSecret = $jiraTokenSecret;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasValidJiraCredentials()
    {
        return $this->jiraAccessToken && $this->jiraTokenSecret;
    }

    /**
     * @return DateTime
     */
    public function getYearlyResetDate()
    {
        $date = new DateTime();

        return $date->setDate($date->format('Y'), 1, 1);
    }

    public function getRemainingPTOHours()
    {
        return $this->getPTOHoursFromReset()
        - $this->getDateEventsHoursOfType(DateEvent::TYPE_PTO, DateEvent::STATUS_APPROVED)
        - $this->getDateEventsHoursOfType(DateEvent::TYPE_UPTO, DateEvent::STATUS_APPROVED);
    }

    public function getRemainingWFHDays()
    {
        return $this->wfhdays - count($this->getDateEventsOfType(DateEvent::TYPE_WFH, new DateTime('01/01/'.date('Y')), DateEvent::STATUS_APPROVED));
    }

    public function getRemainingFlexDays()
    {
        return $this->wfhdays - count($this->getDateEventsOfType(DateEvent::TYPE_FLEX, new DateTime('01/01/'.date('Y')), DateEvent::STATUS_APPROVED));
    }

    public function getExceptionHoursUsed()
    {
        return $this->wfhdays - $this->getDateEventsHoursOfType(DateEvent::TYPE_EXCEPTION);
    }

    public function getDateEventsHoursOfType($type, $status = null)
    {
        $time = 0;

        $endDate = clone $this->getResetDate();
        $endDate->add(new \DateInterval('P1Y'));

        if ($this->dateEvents) {
            /** @var DateEvent $dateEvent */
            foreach ($this->dateEvents as $dateEvent) {
                if ($dateEvent->getType()->getCode() === $type &&
                    $dateEvent->getStart() >= $this->getResetDate() && $dateEvent->getStart() < $endDate) {
                    if ($status !== null) {
                        if ($dateEvent->getStatus() === $status) {
                            $time += $dateEvent->getHoursRequested();
                        }
                    } else {
                        $time += $dateEvent->getHoursRequested();
                    }
                }
            }
        }

        return $time;
    }

    /**
     * @param string $type
     * @return array
     */
    public function getEventsThisYear($type)
    {
        $events = array();

        if ($this->dateEvents) {
            /** @var DateEvent $dateEvent */
            foreach ($this->dateEvents as $dateEvent) {
                if ($dateEvent->getType()->getCode() === $type &&
                    $dateEvent->getStart() >= $this->getResetDate()) {
                    $events[] = $dateEvent;
                }
            }
        }

        return $events;
    }

    /**
     * @return array
     */
    public function getWFHDateEvents()
    {
        return $this->getDateEventsOfType(DateEvent::TYPE_WFH, $this->getYearlyResetDate());
    }

    /**
     * @return array
     */
    public function getFlexDateEvents()
    {
        return $this->getDateEventsOfType(DateEvent::TYPE_FLEX, $this->getYearlyResetDate());
    }

    /**
     * @return array
     */
    public function getExceptionDateEvents()
    {
        return $this->getDateEventsOfType(DateEvent::TYPE_EXCEPTION, $this->getResetDate());
    }

    /**
     * @return array
     */
    public function getPtoDateEvents()
    {
        return $this->getDateEventsOfType(DateEvent::TYPE_PTO, $this->getResetDate());
    }

    /**
     * @param string   $type
     * @param DateTime $fromDate
     *
     * @return array
     */
    public function getDateEventsOfType($type, $fromDate = null, $status = null)
    {
        $events = array();

        $endDate = clone $fromDate;
        $endDate->add(new \DateInterval('P1Y'));

        if ($this->dateEvents) {
            /** @var DateEvent $dateEvent */
            foreach ($this->dateEvents as $dateEvent) {
                if ($dateEvent->getType()->getCode() === $type) {
                    if ($fromDate !== null) {
                        if ($dateEvent->getStart() > $fromDate && $dateEvent->getStart() < $endDate) {
                            if ($status !== null) {
                                if ($dateEvent->getStatus() === $status) {
                                    $events[] = $dateEvent;
                                }
                            } else {
                                $events[] = $dateEvent;
                            }
                        }
                    } else {
                        if ($status !== null) {
                            if ($dateEvent->getStatus() === $status) {
                                $events[] = $dateEvent;
                            }
                        } else {
                            $events[] = $dateEvent;
                        }
                    }
                }
            }
        }

        usort($events, function ($a, $b) {
            return $a->getStart() < $b->getStart();
        });

        return $events;
    }

    /**
     * @param $role
     *
     * @return $this
     */
    public function setRole($role)
    {
        $this->setRoles(array($role));

        return $this;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        $roles = array(
            'ROLE_SUPER_ADMIN',
            'ROLE_COMPANY_ADMIN',
        );

        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return $role;
            }
        }

        return 'ROLE_ADMIN';
    }

    /**
     * @return HipchatConnectionRequest
     */
    public function getHipchatConnection()
    {
        return $this->hipchatConnection;
    }

    /**
     * @param HipchatConnectionRequest $hipchatConnection
     *
     * @return User
     */
    public function setHipchatConnection($hipchatConnection)
    {
        $this->hipchatConnection = $hipchatConnection;

        return $this;
    }
}
