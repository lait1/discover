<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\ReviewService;
use App\DTO\ReviewDTO;
use App\Exception\ValidationErrorException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CommentController extends AbstractController
{
    private ReviewService $reviewService;

    private SerializerInterface $serializer;

    private LoggerInterface $logger;

    public function __construct(
        ReviewService $reviewService,
        SerializerInterface $serializer,
        LoggerInterface $logger
    ) {
        $this->reviewService = $reviewService;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * @Route("/comment/add", name="add-comment", methods={"POST"})
     */
    public function addCommentAction(Request $request): Response
    {
        $dto = new ReviewDTO($request->request->all());
        $file = $request->files->all();

        try {
            $this->reviewService->createReview($dto, $file);

            return $this->json(['message' => 'success']);
//        } catch (ValidationErrorException $e) {
//            return $this->json(['error' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            $this->logger->error(
                'Fail make comment',
                [
                    'error' => $e,
                ]
            );

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
