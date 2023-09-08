<?php
declare(strict_types=1);

namespace App\View;

use App\Entity\User;

class UserView implements \JsonSerializable
{
    private User $entity;

    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'            => $this->entity->getId(),
            'role'          => $this->entity->getRoles(),
            'email'         => $this->entity->getEmail(),
            'telegramToken' => $this->entity->getTelegramToken(),
        ];
    }
}
