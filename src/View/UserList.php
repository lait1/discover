<?php
declare(strict_types=1);

namespace App\View;

class UserList implements \JsonSerializable
{
    private array $user = [];

    public function setUserView(UserView $view): void
    {
        $this->user[] = $view;
    }

    public function jsonSerialize(): array
    {
        return $this->user;
    }
}
