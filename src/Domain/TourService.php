<?php
declare(strict_types=1);

namespace App\Domain;

use App\Entity\Tour;
use App\Repository\TourRepository;

class TourService
{
    public TourRepository $tourRepository;

    public function __construct(TourRepository $tourRepository)
    {
        $this->tourRepository = $tourRepository;
    }

    public function getTourBySlug(string $slug): Tour
    {
        return $this->tourRepository->getTourBySlug($slug);
    }
}
