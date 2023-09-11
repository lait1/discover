<?php
declare(strict_types=1);

namespace App\Domain;

use App\DTO\TourCreateDTO;
use App\DTO\UpdateBannerInfoDTO;
use App\DTO\UpdateDescriptionDTO;
use App\DTO\UpdatePriceDTO;
use App\DTO\UpdateWhereToGoDTO;
use App\Entity\Tour;
use App\Entity\TourDescription;
use App\Repository\CategoryRepository;
use App\Repository\TourOptionRepository;
use App\Repository\TourRepository;
use App\View\TourList;
use App\View\TourView;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TourService
{
    private TourRepository $tourRepository;

    private TourOptionRepository $tourOptionRepository;

    private FileUploader $fileUploader;

    private CategoryRepository $categoryRepository;

    public function __construct(
        TourRepository $tourRepository,
        TourOptionRepository $tourOptionRepository,
        FileUploader $fileUploader,
        CategoryRepository $categoryRepository
    ) {
        $this->tourRepository = $tourRepository;
        $this->tourOptionRepository = $tourOptionRepository;
        $this->fileUploader = $fileUploader;
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllTours(): TourList
    {
        $tourList = new TourList();
        /** @var Tour $tour */
        foreach ($this->tourRepository->getAllTours() as $tour) {
            $tourView = $this->buildTourView($tour);

            $tourList->setTourView($tourView);
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
        return $this->buildTourView($this->tourRepository->getById($id));
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

    public function updateDescriptionInfo(UpdateDescriptionDTO $dto, ?UploadedFile $file): void
    {
        $tour = $this->tourRepository->getById($dto->tourId);
        $imagePath = $this->fileUploader->upload($file);

        $tourDesc = new TourDescription($dto->header, $dto->content, $imagePath);
        $tour->addTourDescription($tourDesc);

        $this->tourRepository->save($tour);
    }

    public function updatePriceInfo(UpdatePriceDTO $dto): void
    {
        $tour = $this->tourRepository->getById($dto->id);
        $tour->setPrice((int) $dto->price);
        $tour->setIncludePriceDetails($dto->includePrice);
        $tour->setExcludePriceDetails($dto->excludePrice);

        $this->tourRepository->save($tour);
    }

    public function publish(int $tourId): void
    {
        $tour = $this->tourRepository->getById($tourId);
        $tour->setPublic(true);

        $this->tourRepository->save($tour);
    }

    public function unpublish(int $tourId): void
    {
        $tour = $this->tourRepository->getById($tourId);
        $tour->setPublic(false);

        $this->tourRepository->save($tour);
    }

    private function buildTourView(Tour $tour): TourView
    {
        $inPrice = $this->tourOptionRepository->getByIds($tour->getIncludePriceDetails());
        $exPrice = $this->tourOptionRepository->getByIds($tour->getExcludePriceDetails());

        return new TourView($tour, $inPrice, $exPrice);
    }
}
