<?php
declare(strict_types=1);

namespace App\Domain;

use App\DTO\ReviewDTO;
use App\Entity\Review;
use App\Repository\ClientRepository;
use App\Repository\ReviewRepository;
use App\Repository\TourRepository;
use App\View\ReviewList;
use App\View\ReviewView;

class ReviewService
{
    public ReviewRepository $reviewRepository;

    public TourRepository $tourRepository;

    public ClientRepository $clientRepository;

    public function __construct(
        ReviewRepository $reviewRepository,
        TourRepository $tourRepository,
        ClientRepository $clientRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->reviewRepository = $reviewRepository;
        $this->tourRepository = $tourRepository;
    }

    public function getReviewByTourId(int $tourId): ReviewList
    {
        $reviewList = new ReviewList();
        $reviews = $this->reviewRepository->getByTourId($tourId);
        foreach ($reviews as $review) {
            $reviewList->setReviewView(new ReviewView($review));
        }

        return $reviewList;
    }

    public function createReview(ReviewDTO $dto): void
    {
        $client = $this->clientRepository->getClientByPhone($dto->phone);
        $tour = $this->tourRepository->getById($dto->tourId);

        $review = new Review($dto->text, $dto->rating);
        $review->setAuthor($client);
        $review->setTour($tour);
        $this->reviewRepository->add($review, true);
    }
}
