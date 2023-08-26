<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private Client $author;

    /** @ORM\ManyToOne(targetEntity=Tour::class, inversedBy="orders") */
    private Tour $tour;

    /** @ORM\Column(type="integer", nullable=false, options={"unsigned": true}) */
    private int $reservationDate;

    /** @ORM\Column(type="integer", nullable=false, options={"unsigned": true}) */
    private int $countPeople;

    /** @ORM\Column(type="text", nullable=true) */
    private ?string $description;

    /** @ORM\Column(type="boolean") */
    private bool $confirmed = false;

    /** @ORM\Column(type="integer", nullable=false, options={"unsigned": true}) */
    private int $createdAt;

    /** @ORM\Column(type="integer", nullable=true, options={"unsigned": true}) */
    private int $updatedAt;

    public function __construct(
        Client $author,
        Tour $tour,
        int $reservationDate,
        int $countPeople,
        ?string $description = null
    ) {
        $this->author = $author;
        $this->tour = $tour;
        $this->reservationDate = $reservationDate;
        $this->countPeople = $countPeople;
        $this->description = $description;
        $this->createdAt = time();
        $this->updatedAt = time();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
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

    public function getCreatedAt(): DateTimeImmutable
    {
        return (new \DateTimeImmutable())->setTimestamp($this->createdAt);
    }
}
