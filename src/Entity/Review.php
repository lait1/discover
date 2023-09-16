<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /** @ORM\Column(type="text") */
    private string $text;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private Client $author;

    /** @ORM\Column(type="smallint") */
    private int $assessment;

    /** @ORM\Column(type="boolean") */
    private bool $public = false;

    /** @ORM\Column(type="boolean") */
    private bool $showMainPage = false;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private string $answer;

    /** @ORM\ManyToOne(targetEntity=Tour::class, inversedBy="reviews") */
    private $tour;

    /** @ORM\OneToMany(targetEntity=ReviewPhoto::class, mappedBy="reviews", cascade={"persist", "remove"}) */
    private $reviewPhotos;

    /** @ORM\Column(name="created_at", type="integer", nullable=false, options={"unsigned": true}) */
    private int $createdAt;

    public function __construct(string $text, int $assessment)
    {
        $this->text = trim(strip_tags($text));
        $this->assessment = $assessment;
        $this->createdAt = time();
        $this->reviewPhotos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getShortText(): string
    {
        $text = $this->text;

        if (strlen($text) > 400) {
            $string = substr($text, 0, 400);
            $formattedText = substr($string, 0, strrpos($string, ' '));

            return $formattedText . '...';
        }

        return $text;
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

    public function showMainPage(): bool
    {
        return $this->showMainPage;
    }

    public function setPublic(): void
    {
        $this->public = true;
    }

    public function setUnPublic(): void
    {
        $this->public = false;
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

    public function getTour(): ?Tour
    {
        return $this->tour;
    }

    public function setTour(?Tour $tour): self
    {
        $this->tour = $tour;

        return $this;
    }

    /**
     * @return Collection<int, ReviewPhoto>
     */
    public function getReviewPhotos(): Collection
    {
        return $this->reviewPhotos;
    }

    public function addReviewPhoto(ReviewPhoto $reviewPhoto): self
    {
        if (!$this->reviewPhotos->contains($reviewPhoto)) {
            $this->reviewPhotos[] = $reviewPhoto;
            $reviewPhoto->setReviews($this);
        }

        return $this;
    }

    public function removeReviewPhoto(ReviewPhoto $reviewPhoto): self
    {
        if ($this->reviewPhotos->removeElement($reviewPhoto)) {
            // set the owning side to null (unless already changed)
            if ($reviewPhoto->getReviews() === $this) {
                $reviewPhoto->setReviews(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return (new \DateTimeImmutable())->setTimestamp($this->createdAt);
    }

    public function setShowMainPage(): void
    {
        $this->showMainPage = true;
    }

    public function unsetShowMainPage(): void
    {
        $this->showMainPage = false;
    }
}
