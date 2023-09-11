<?php
declare(strict_types=1);

namespace App\DTO;

class OrderMyTourDTO
{
    public int $countDay;

    public int $countPeople;

    public string $phone;

    public string $name;

    public array $selectedCategories;

    public ?string $text;
}
