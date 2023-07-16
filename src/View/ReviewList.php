<?php
declare(strict_types=1);

namespace App\View;

class ReviewList implements \JsonSerializable
{
    private array $reviews = [];

    public function setReviewView(ReviewView $view): void
    {
        $this->reviews[] = $view;
    }

    public function jsonSerialize(): array
    {
        return $this->reviews;
    }
}
