<?php
declare(strict_types=1);

namespace App\DTO;

class OrderDTO
{
    public int $tourId;

    public string $date;

    public string $name;

    public int $countPeople;

    public string $phone;

    public ?string $text;
}
