<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * EventType.
 *
 * @ApiResource
 * @ORM\Table(name="event_type")
 * @ORM\Entity
 */
class EventType
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
     * @ORM\Column(name="name", type="string", length=25)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=25)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="jira_key", type="string", length=25, nullable=true)
     */
    private $jiraKey;

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
     * @return EventType
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
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return EventType
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Set jiraKey.
     *
     * @param string $jiraKey
     *
     * @return EventType
     */
    public function setJiraKey($jiraKey)
    {
        $this->jiraKey = $jiraKey;

        return $this;
    }

    /**
     * Get jiraKey.
     *
     * @return string
     */
    public function getJiraKey()
    {
        return $this->jiraKey;
    }

    public function __toString()
    {
        return $this->name;
    }
}
