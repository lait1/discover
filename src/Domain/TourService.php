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
use App\Enum\CurrencyEnum;
use App\Repository\CategoryRepository;
use App\Repository\TourDescriptionRepository;
use App\Repository\TourOptionRepository;
use App\Repository\TourRepository;
use App\View\PriceView;
use App\View\TourList;
use App\View\TourView;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TourService
{
    private TourRepository $tourRepository;

    private TourOptionRepository $tourOptionRepository;

    private TourDescriptionRepository $tourDescriptionRepository;

    private CategoryRepository $categoryRepository;

    private ExchangeService $exchangeService;

    private FileUploader $fileUploader;

    public function __construct(
        TourRepository $tourRepository,
        TourOptionRepository $tourOptionRepository,
        TourDescriptionRepository $tourDescriptionRepository,
        CategoryRepository $categoryRepository,
        ExchangeService $exchangeService,
        FileUploader $fileUploader
    ) {
        $this->tourRepository = $tourRepository;
        $this->tourOptionRepository = $tourOptionRepository;
        $this->tourDescriptionRepository = $tourDescriptionRepository;
        $this->categoryRepository = $categoryRepository;
        $this->exchangeService = $exchangeService;
        $this->fileUploader = $fileUploader;
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

    public function removeDescriptionAction(int $id): void
    {
        $this->tourDescriptionRepository->remove(
            $this->tourDescriptionRepository->find($id)
        );
    }

    public function updateDescriptionInfo(UpdateDescriptionDTO $dto, ?UploadedFile $file): void
    {
        $tour = $this->tourRepository->getById($dto->tourId);
        $description = $this->tourDescriptionRepository->find($dto->id);

        if ($description) {
            $description->setContent($dto->content);
            $description->setHeader($dto->header);
            if ($file) {
                $imagePath = $this->fileUploader->upload($file);
                $description->setImage($imagePath);
            }
        } else {
            $imagePath = $this->fileUploader->upload($file);
            $description = new TourDescription($dto->header, $dto->content, $imagePath);
            $description->setTour($tour);
        }

        $this->tourDescriptionRepository->save($description);
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

    public function remove(int $tourId): void
    {
        $tour = $this->tourRepository->getById($tourId);

        $this->tourRepository->remove($tour);
    }

    public function getPriceByTourId(int $id): PriceView
    {
        $tour = $this->tourRepository->getById($id);
        $priceView = new PriceView($tour->getPrice(), CurrencyEnum::GEL);
        foreach ($this->exchangeService->calculate($tour->getPrice()) as $currency => $rate) {
            $priceView->setRates($rate, $currency);
        }

        return $priceView;
    }

    private function buildTourView(Tour $tour): TourView
    {
        $inPrice = $this->tourOptionRepository->getByIds($tour->getIncludePriceDetails());
        $exPrice = $this->tourOptionRepository->getByIds($tour->getExcludePriceDetails());

        return new TourView($tour, $inPrice, $exPrice);
    }
}
