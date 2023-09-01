<?php

namespace App\Controller\Admin;

use App\Domain\TourService;
use App\Domain\UploadService;
use App\DTO\TourCreateDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AdminController extends AbstractController
{
    private TourService $tourService;

    private UploadService $uploadService;

    private SerializerInterface $serializer;

    public function __construct(
        TourService $tourService,
        UploadService $uploadService,
        SerializerInterface $serializer
    ) {
        $this->tourService = $tourService;
        $this->uploadService = $uploadService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/get-categories", methods={"GET"})
     */
    public function getCategoriesAction(): Response
    {
        return $this->json($this->tourService->getCategories());
    }

    /**
     * @Route("/tour/create-tour", methods={"POST"})
     */
    public function createTourAction(Request $request): Response
    {
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            TourCreateDTO::class,
            'json'
        );
        try {
            $tour = $this->tourService->createTour($dto);

            return $this->json(['message' => 'success', 'tourId' => $tour->getId()]);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/tour/upload-photo/{tourId}", methods={"POST"})
     */
    public function uploadTourPhotoAction(Request $request, int $tourId): Response
    {
        try {
            $photos = $this->uploadService->uploadTourPhoto($request->files->all(), $tourId);

            return $this->json(['message' => 'success', 'photos' => $photos]);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/tour/remove-photo/{photoId}", methods={"POST"})
     */
    public function removeTourPhotoAction(Request $request, int $photoId): Response
    {
        try {
            $this->uploadService->removeTourPhoto($photoId);

            return $this->json(['message' => 'success']);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/tour/get-tour-list", methods={"GET"})
     */
    public function tourListAction(): Response
    {
        return $this->json($this->tourService->getAllTours());
    }

    /**
     * @Route("/tour/get-tour-info/{id}", methods={"GET"})
     */
    public function tourInfoAction($id): Response
    {
        return $this->json($this->tourService->getTourById($id));
    }

    /**
     * @Route("/get-reservations", methods={"GET"})
     */
    public function reservationsAction(): Response
    {
        return $this->json(['get reservations']);
    }
}
