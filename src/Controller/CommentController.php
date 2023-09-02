<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\ReviewService;
use App\DTO\ReviewDTO;
use App\Exception\ValidationErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CommentController extends AbstractController
{
    private ReviewService $reviewService;

    private SerializerInterface $serializer;

    public function __construct(ReviewService $reviewService, SerializerInterface $serializer)
    {
        $this->reviewService = $reviewService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/comment/add", name="add-comment", methods={"POST"})
     */
    public function addCommentAction(Request $request): Response
    {
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            ReviewDTO::class,
            'json'
        );
        try {
            $this->reviewService->createReview($dto);

            return $this->json(['message' => 'success']);
        } catch (ValidationErrorException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/comment/get-comments/{id}", name="get-comment", methods={"GET"})
     */
    public function listCommentAction(Request $request, int $id): Response
    {
        try {
            return $this->json($this->reviewService->getReviewByTourId($id));
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/comment/get-best-comments", name="get-best-comment", methods={"GET"})
     */
    public function getBestCommentAction(): Response
    {
        try {
            return $this->json($this->reviewService->getReviewsForMainPage());
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
