<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /** @ORM\Column(type="string", length=255) */
    private string $text;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private Client $author;

    /** @ORM\Column(type="smallint") */
    private int $assessment;

    /** @ORM\Column(type="boolean") */
    private bool $public;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private string $answer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getAuthor(): Client
    {
        return $this->author;
    }

    public function setAuthor(Client $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getAssessment(): int
    {
        return $this->assessment;
    }

    public function setAssessment(int $assessment): self
    {
        $this->assessment = $assessment;

        return $this;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function setPublic(bool $isPublic): self
    {
        $this->public = $isPublic;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}
