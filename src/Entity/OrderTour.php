<?php
declare(strict_types=1);

namespace App\Entity;

use App\Enum\OrderStatusEnum;
use App\Repository\OrderTourRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderTourRepository::class)
 */
class OrderTour
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
    private Client $client;

    /** @ORM\ManyToOne(targetEntity=Tour::class, inversedBy="orders")
     *  @ORM\JoinColumn(nullable=false)
     */
    private Tour $tour;

    /** @ORM\Column(type="integer", nullable=false, options={"unsigned": true}) */
    private int $countPeople;

    /** @ORM\Column(type="integer", nullable=true, options={"unsigned": true}) */
    private int $countDay;

    /** @ORM\Column(name="details", type="json", nullable=true) */
    private ?array $details;

    /** @ORM\Column(type="text", nullable=true) */
    private ?string $comment;

    /** @ORM\Column(type="string", length=10) */
    private string $status;

    /** @ORM\Column(type="integer", nullable=false, options={"unsigned": true}) */
    private int $createdAt;

    /** @ORM\Column(type="integer", nullable=true, options={"unsigned": true}) */
    private int $updatedAt;

    /** @ORM\OneToMany(targetEntity=ReservationDate::class, mappedBy="orderTour", cascade={"persist"}) */
    private $reservationDate;

    public function __construct(
        int $countPeople,
        ?string $description = null
    ) {
        $this->countPeople = $countPeople;
        $this->comment = $description ? trim(strip_tags($description)) : null;
        $this->status = OrderStatusEnum::WAIT;
        $this->createdAt = time();
        $this->updatedAt = time();
        $this->reservationDate = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getTour(): ?Tour
    {
        return $this->tour;
    }

    public function isUniqTour(): bool
    {
        return $this->tour->getSlug() === Tour::UNIQ_TOUR;
    }

    public function setTour(Tour $tour): self
    {
        $this->tour = $tour;

        return $this;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getFormattedReservationDate(): string
    {
        if ($this->reservationDate->isEmpty()) {
            return 'Нет даты';
        }
        $reservationDate = $this->reservationDate->first();

        return $reservationDate->getReservationDate()->format('d-m-Y');
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return (new \DateTimeImmutable())->setTimestamp($this->createdAt);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getCountPeople(): int
    {
        return $this->countPeople;
    }

    public function getStatus(): OrderStatusEnum
    {
        return new OrderStatusEnum($this->status);
    }

    public function approve(): void
    {
        $this->status = OrderStatusEnum::APPROVE;
        $this->updatedAt = time();
    }

    public function reject(): void
    {
        $this->status = OrderStatusEnum::REJECT;
        $this->updatedAt = time();
    }

    public function getCountDay(): int
    {
        return $this->countDay;
    }

    public function setCountDay(int $countDay): void
    {
        $this->countDay = $countDay;
    }

    public function getSelectedCategory(): string
    {
        $textArray = array_column($this->details, 'text');

        return implode(', ', $textArray);
    }

    public function setDetails(array $details): void
    {
        $this->details = $details;
    }

    /**
     * @return Collection<int, ReservationDate>
     */
    public function getReservationDate(): Collection
    {
        return $this->reservationDate;
    }

    public function addReservationDate(ReservationDate $reservationDate): self
    {
        if (!$this->reservationDate->contains($reservationDate)) {
            $this->reservationDate[] = $reservationDate;
            $reservationDate->setOrderTour($this);
        }

        return $this;
    }

    public function removeReservationDate(ReservationDate $reservationDate): self
    {
        if ($this->reservationDate->removeElement($reservationDate)) {
            // set the owning side to null (unless already changed)
            if ($reservationDate->getOrderTour() === $this) {
                $reservationDate->setOrderTour(null);
            }
        }

        return $this;
    }

    public function isReject(): bool
    {
        return $this->status === OrderStatusEnum::REJECT;
    }

    public function isApprove(): bool
    {
        return $this->status === OrderStatusEnum::APPROVE;
    }
}
