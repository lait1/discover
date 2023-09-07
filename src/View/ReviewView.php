<?php
declare(strict_types=1);

namespace App\View;

use App\Entity\Review;

class ReviewView implements \JsonSerializable
{
    private Review $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'           => $this->review->getId(),
            'author'       => $this->review->getAuthor()->getName() ?? $this->review->getAuthor()->getPhone(),
            'text'         => $this->review->getText(),
            'shortText'    => $this->review->getShortText(),
            'tour'         => new TourView($this->review->getTour()),
            'stars'        => $this->review->getAssessment(),
            'isPublic'     => $this->review->isPublic(),
            'showMainPage' => $this->review->showMainPage(),
            'date'         => $this->review->getCreatedAt()->format('d.m.Y'),
        ];
    }
}
