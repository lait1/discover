<?php

namespace App\Controller\Admin;

use App\Domain\ReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CommentController extends AbstractController
{
    private ReviewService $reviewService;

    private SerializerInterface $serializer;

    public function __construct(
        ReviewService $reviewService,
        SerializerInterface $serializer
    ) {
        $this->reviewService = $reviewService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/comment/get-comments", methods={"GET"})
     */
    public function getCommentsAction(): Response
    {
        return $this->json($this->reviewService->getAllComments());
    }

    /**
     * @Route("/comment/publish/{commentId}", methods={"POST"})
     */
    public function publishAction(Request $request, int $commentId): Response
    {
        try {
            $this->reviewService->publish($commentId);

            return $this->json(['message' => 'success']);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/comment/publish-to-main/{commentId}", methods={"POST"})
     */
    public function publishMainAction(Request $request, int $commentId): Response
    {
        try {
            $this->reviewService->publishMain($commentId);

            return $this->json(['message' => 'success']);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/comment/unpublish/{commentId}", methods={"POST"})
     */
    public function unPublishAction(Request $request, int $commentId): Response
    {
        try {
            $this->reviewService->unPublish($commentId);

            return $this->json(['message' => 'success']);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/comment/unpublish-main/{commentId}", methods={"POST"})
     */
    public function unPublishMainAction(Request $request, int $commentId): Response
    {
        try {
            $this->reviewService->unPublishMain($commentId);

            return $this->json(['message' => 'success']);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
