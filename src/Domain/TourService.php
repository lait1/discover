<?php
declare(strict_types=1);

namespace App\Domain;

use App\DTO\TourCreateDTO;
use App\Entity\Tour;
use App\Repository\TourRepository;
use App\View\TourList;
use App\View\TourView;

class TourService
{
    private TourRepository $tourRepository;

    public function __construct(TourRepository $tourRepository)
    {
        $this->tourRepository = $tourRepository;
    }

    public function getAllTours(): TourList
    {
        $tourList = new TourList();
        foreach ($this->tourRepository->getAllTours() as $tour) {
            $tourList->setTourView(new TourView($tour));
        }

        return $tourList;
    }

    public function getTourBySlug(string $slug): Tour
    {
        return $this->tourRepository->getTourBySlug($slug);
    }

    public function getTourById(int $id): TourView
    {
        $tour = $this->tourRepository->getById($id);

        return new TourView($tour);
    }

    public function createTour(TourCreateDTO $dto): Tour
    {
        $tour = new Tour($dto->name);

        return $this->tourRepository->save($tour);
    }
}
