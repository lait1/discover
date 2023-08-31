<?php

namespace App\Controller\Admin;

use App\Domain\TourService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private TourService $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;
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
        return $this->json(['get tour']);
    }

    /**
     * @Route("/get-reservations", methods={"GET"})
     */
    public function reservationsAction(): Response
    {
        return $this->json(['get reservations']);
    }
}
