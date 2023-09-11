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

    /**
     * @throws \App\Exception\ValidationErrorException
     */
    public function createReview(ReviewDTO $dto): void
    {
        $client = $this->clientRepository->getClientByPhone($dto->phone);
        $tour = $this->tourRepository->getById($dto->tourId);

        $review = new Review($dto->text, $dto->rating);
        $review->setAuthor($client);
        $review->setTour($tour);
        $this->reviewRepository->save($review);
    }

    public function getReviewByTourId(int $tourId): ReviewList
    {
        return $this->buildReviewList($this->reviewRepository->getByTourId($tourId));
    }

    public function getReviewsForMainPage(): ReviewList
    {
        return $this->buildReviewList($this->reviewRepository->getReviewsForMainPage());
    }

    public function getAllComments(): ReviewList
    {
        return $this->buildReviewList($this->reviewRepository->getAllComments());
    }

    public function publish(int $commentId): void
    {
        $review = $this->reviewRepository->getById($commentId);
        $review->setPublic();
        $this->reviewRepository->save($review);
    }

    public function unPublish(int $commentId): void
    {
        $review = $this->reviewRepository->getById($commentId);
        $review->setUnPublic();
        $this->reviewRepository->save($review);
    }

    public function publishMain(int $commentId): void
    {
        $review = $this->reviewRepository->getById($commentId);
        $review->setShowMainPage();
        $this->reviewRepository->save($review);
    }

    public function unPublishMain(int $commentId): void
    {
        $review = $this->reviewRepository->getById($commentId);
        $review->unsetShowMainPage();
        $this->reviewRepository->save($review);
    }

    private function buildReviewList(array $reviews): ReviewList
    {
        $reviewList = new ReviewList();
        foreach ($reviews as $review) {
            $reviewList->setReviewView(new ReviewView($review));
        }

        return $reviewList;
    }
}
