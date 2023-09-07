<?php
declare(strict_types=1);

namespace App\View;

use App\Entity\Client;

class ClientView implements \JsonSerializable
{
    private Client $entity;

    public function __construct(Client $review)
    {
        $this->entity = $review;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->entity->getId(),
            'name'  => $this->entity->getName(),
            'phone' => $this->entity->getPhone(),
            'date'  => $this->entity->getCreatedAt()->format('d.m.Y'),
        ];
    }
}
