<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ShoutOut.
 *
 * @ApiResource
 * @ORM\Table(name="shout_out")
 * @ORM\Entity
 */
class ShoutOut
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
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRequested", type="datetime")
     */
    private $dateRequested;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="suppliesRequested")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userRequested;

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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return ShoutOut
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateRequested()
    {
        return $this->dateRequested;
    }

    /**
     * @param DateTime $dateRequested
     * @return ShoutOut
     */
    public function setDateRequested($dateRequested)
    {
        $this->dateRequested = $dateRequested;
        return $this;
    }

    /**
     * @return User
     */
    public function getUserRequested()
    {
        return $this->userRequested;
    }

    /**
     * @param User $userRequested
     * @return ShoutOut
     */
    public function setUserRequested($userRequested)
    {
        $this->userRequested = $userRequested;
        return $this;
    }

    public function __toString()
    {
        return $this->message;
    }
}
