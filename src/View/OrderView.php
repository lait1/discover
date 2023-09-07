<?php
declare(strict_types=1);

namespace App\View;

use App\Entity\OrderTour;

class OrderView implements \JsonSerializable
{
    private OrderTour $entity;

    public function __construct(OrderTour $orderTour)
    {
        $this->entity = $orderTour;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'              => $this->entity->getId(),
            'client'          => new ClientView($this->entity->getClient()),
            'tour'            => new TourView($this->entity->getTour()),
            'status'          => $this->entity->getStatus(),
            'dateReservation' => $this->entity->getReservationDate()->format('d.m.Y'),
            'countPeople'     => $this->entity->getCountPeople(),
            'comment'         => $this->entity->getComment(),
            'created'         => $this->entity->getCreatedAt()->format('d.m.Y'),
        ];
    }
}
