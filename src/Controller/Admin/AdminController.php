<?php

namespace App\Controller\Admin;

use App\Domain\TourService;
use App\DTO\TourCreateDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AdminController extends AbstractController
{
    private TourService $tourService;

    private SerializerInterface $serializer;

    public function __construct(TourService $tourService, SerializerInterface $serializer)
    {
        $this->tourService = $tourService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/create-tour", methods={"POST"})
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
     * @Route("/get-tour-list", methods={"GET"})
     */
    public function tourListAction(): Response
    {
        return $this->json($this->tourService->getAllTours());
    }

    /**
     * @Route("/get-tour-info/{id}", methods={"GET"})
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
