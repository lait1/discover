<?php
declare(strict_types=1);

namespace App\DTO;

class UserEditDTO
{
    public int $id;

    public string $email;

    public string $password;

    public array $role;

    public ?string $telegramToken = null;
}
