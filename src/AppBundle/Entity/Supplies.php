<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Supplies.
 *
 * @ApiResource
 * @ORM\Table(name="supplies")
 * @ORM\Entity
 */
class Supplies
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
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRequested", type="datetime")
     */
    private $dateRequested;

    /**
     * @var bool
     *
     * @ORM\Column(name="ordered", type="boolean", options={"default"=false})
     */
    private $ordered;

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
     * Set name.
     *
     * @param string $name
     *
     * @return Supplies
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dateRequested.
     *
     * @param \DateTime $dateRequested
     *
     * @return Supplies
     */
    public function setDateRequested($dateRequested)
    {
        $this->dateRequested = $dateRequested;

        return $this;
    }

    /**
     * Get dateRequested.
     *
     * @return \DateTime
     */
    public function getDateRequested()
    {
        return $this->dateRequested;
    }

    /**
     * Set ordered.
     *
     * @param bool $ordered
     *
     * @return Supplies
     */
    public function setOrdered($ordered)
    {
        $this->ordered = $ordered;

        return $this;
    }

    /**
     * Get ordered.
     *
     * @return bool
     */
    public function getOrdered()
    {
        return $this->ordered;
    }

    /**
     * Set userRequested.
     *
     * @param User $userRequested
     *
     * @return Supplies
     */
    public function setUserRequested(User $userRequested)
    {
        $this->userRequested = $userRequested;

        return $this;
    }

    /**
     * Get userRequested.
     *
     * @return User
     */
    public function getUserRequested()
    {
        return $this->userRequested;
    }

    public function __toString()
    {
        return $this->name;
    }
}
