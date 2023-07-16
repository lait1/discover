<?php
declare(strict_types=1);

namespace App\DTO;

class ReviewDTO
{
    public int $tourId;

    public int $rating;

    public string $name;

    public string $phone;

    public string $text;
}
