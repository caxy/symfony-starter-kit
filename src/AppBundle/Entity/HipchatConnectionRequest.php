<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HipchatConnectionRequest.
 *
 * @ORM\Table(name="hipchat_connection_requests")
 * @ORM\Entity
 */
class HipchatConnectionRequest
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
     * @ORM\Column(name="hipchat_user_id", type="string", length=255)
     */
    private $hipchatUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="hipchat_user_name", type="string", length=255)
     */
    private $hipchatUserName;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User", inversedBy="hipchatConnection")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Set userId.
     *
     * @param string $hipchatUserId
     *
     * @return HipchatConnectionRequest
     */
    public function setHipchatUserId($hipchatUserId)
    {
        $this->hipchatUserId = $hipchatUserId;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return string
     */
    public function getHipchatUserId()
    {
        return $this->hipchatUserId;
    }

    /**
     * Set userName.
     *
     * @param string $hipchatUserName
     *
     * @return HipchatConnectionRequest
     */
    public function setHipchatUserName($hipchatUserName)
    {
        $this->hipchatUserName = $hipchatUserName;

        return $this;
    }

    /**
     * Get userName.
     *
     * @return string
     */
    public function getHipchatUserName()
    {
        return $this->hipchatUserName;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return HipchatConnectionRequest
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function __toString()
    {
        return $this->hipchatUserName;
    }
}
