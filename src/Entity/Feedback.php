<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FeedbackRepository::class)
 */
class Feedback
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ ne peut pas etre vide")
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ce champ ne peut pas etre vide")
     * @Assert\Length(max="50", maxMessage="Ce champ est trop long")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(max="50", maxMessage="Ce champ est trop long")
     * @Assert\NotBlank(message="Ce champ ne peut pas etre vide")
     */
    private $job;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ispublished = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getIspublished(): ?bool
    {
        return $this->ispublished;
    }

    public function setIspublished(bool $ispublished): self
    {
        $this->ispublished = $ispublished;

        return $this;
    }

}
