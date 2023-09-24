<?php

namespace App\Controller\Admin;

use App\Domain\OrderService;
use App\Domain\TourService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private TourService $tourService;

    private OrderService $orderService;

    public function __construct(
        TourService $tourService,
        OrderService $orderService
    ) {
        $this->tourService = $tourService;
        $this->orderService = $orderService;
    }

    /**
     * @Route("/get-categories", methods={"GET"})
     */
    public function getCategoriesAction(): Response
    {
        return $this->json($this->tourService->getCategories());
    }

    /**
     * @Route("/get-options", methods={"GET"})
     */
    public function getOptionsAction(): Response
    {
        return $this->json($this->tourService->getOptions());
    }

    /**
     * @Route("/toggle-dates", methods={"POST"})
     */
    public function getToggleDatesAction(Request $request): Response
    {
        $rawDate = $request->getContent();
        if ($rawDate === null) {
            return $this->json(['error' => 'date empty'], 400);
        }
        $result = $this->orderService->toggleDates($rawDate, $this->getUser());

        return $this->json(['message' => 'success', 'result' => $result]);
    }

    /**
     * @Route("/get-unavailable-dates", methods={"GET"})
     */
    public function getUnavailableDatesAction(): Response
    {
        return $this->json($this->orderService->getBookedTourDates());
    }

    /**
     * @Route("/get-marked-dates", methods={"GET"})
     */
    public function getMarkedDatesAction(): Response
    {
        return $this->json($this->orderService->getMarkedDates());
    }
}
