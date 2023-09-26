<?php
declare(strict_types=1);

namespace App\DTO;

class OrderCorporateDTO
{
    public int $countPeople;

    public string $phone;

    public string $name;

    public ?string $text;
}
