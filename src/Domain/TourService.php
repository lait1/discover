<?php
declare(strict_types=1);

namespace App\Domain;

use App\DTO\TourCreateDTO;
use App\DTO\UpdateBannerInfoDTO;
use App\DTO\UpdateWhereToGoDTO;
use App\Entity\Tour;
use App\Repository\CategoryRepository;
use App\Repository\TourOptionRepository;
use App\Repository\TourRepository;
use App\View\TourList;
use App\View\TourView;

class TourService
{
    private TourRepository $tourRepository;

    private TourOptionRepository $tourOptionRepository;

    private CategoryRepository $categoryRepository;

    public function __construct(
        TourRepository $tourRepository,
        TourOptionRepository $tourOptionRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->tourRepository = $tourRepository;
        $this->tourOptionRepository = $tourOptionRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllTours(): TourList
    {
        $tourList = new TourList();
        foreach ($this->tourRepository->getAllTours() as $tour) {
            $tourList->setTourView(new TourView($tour));
        }

        return $tourList;
    }

    public function getPublicTours(): array
    {
        return $this->tourRepository->getPublicTours();
    }

    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
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

    public function updateBannerInfo(UpdateBannerInfoDTO $bannerInfoDTO): void
    {
        $tour = $this->tourRepository->getById($bannerInfoDTO->id);
        $categories = $this->categoryRepository->getByIds($bannerInfoDTO->categories);

        $tour->setName($bannerInfoDTO->name);
        $tour->setTitle($bannerInfoDTO->title);
        $tour->setCategories($categories);

        $this->tourRepository->save($tour);
    }

    public function updateWhereToGoInfo(UpdateWhereToGoDTO $whereToGoDTO): void
    {
        $tour = $this->tourRepository->getById($whereToGoDTO->id);

        $tour->setComplexity($whereToGoDTO->complexity);
        $tour->setLongTime($whereToGoDTO->longTime);
        $tour->setGroupSize((int) $whereToGoDTO->groupSize);
        $tour->setDescription($whereToGoDTO->description);

        $this->tourRepository->save($tour);
    }

    public function getOptions(): array
    {
        return $this->tourOptionRepository->findAll();
    }
}
