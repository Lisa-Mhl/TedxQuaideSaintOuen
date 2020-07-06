<?php

namespace App\Entity;

use App\Repository\StatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatsRepository::class)
 */
class Stats
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $attendees;

    /**
     * @ORM\Column(type="integer")
     */
    private $speakers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttendees(): ?int
    {
        return $this->attendees;
    }

    public function setAttendees(int $attendees): self
    {
        $this->attendees = $attendees;

        return $this;
    }

    public function getSpeakers(): ?int
    {
        return $this->speakers;
    }

    public function setSpeakers(int $speakers): self
    {
        $this->speakers = $speakers;

        return $this;
    }
}
