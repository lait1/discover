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

    public function __construct(array $data)
    {
        $this->tourId = (int) $data['tourId'];
        $this->rating = (int) $data['rating'];
        $this->name = $data['name'];
        $this->phone = $data['phone'];
        $this->text = $data['text'];
    }
}
