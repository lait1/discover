<?php

namespace App\Controller\Admin;

use App\Domain\TourService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private TourService $tourService;

    public function __construct(
        TourService $tourService
    ) {
        $this->tourService = $tourService;
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
}
