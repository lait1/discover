<?php
declare(strict_types=1);

namespace App\DTO;

class UserCreateDTO
{
    public string $email;

    public string $password;

    public array $role;

    public ?string $telegramToken = null;
}
