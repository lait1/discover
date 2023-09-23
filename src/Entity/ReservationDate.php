<?php

namespace App\Entity;

use App\Repository\ReservationDateRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationDateRepository::class)
 */
class ReservationDate
{
    /**
     * @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @ORM\Column(type="date", nullable=false, options={"unsigned": true}) */
    private DateTimeInterface $reservationDate;

    /** @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservationDate") */
    private $user;

    /** @ORM\Column(type="integer", nullable=false, options={"unsigned": true}) */
    private int $createdAt;

    /** @ORM\ManyToOne(targetEntity=OrderTour::class, inversedBy="reservationDate", cascade={"persist"}) */
    private $orderTour;

    public function __construct(DateTimeInterface $date)
    {
        $this->reservationDate = $date;
        $this->createdAt = time();
    }

    public function getOrder(): ?OrderTour
    {
        return $this->orderTour;
    }

    public function getReservationDate(): DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setOrderTour(OrderTour $orderTour): void
    {
        $this->orderTour = $orderTour;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getOrderTour(): ?OrderTour
    {
        return $this->orderTour;
    }
}
