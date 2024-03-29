<?php
declare(strict_types=1);

namespace App\DTO;

class UpdatePriceDTO
{
    public int $id;

    public $price;

    public array $includePrice;

    public array $excludePrice;
}
