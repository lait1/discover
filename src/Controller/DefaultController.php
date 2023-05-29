<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\TourService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private TourService $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;
    }

    /**
     * @Route("/")
     */
    public function indexAction(): Response
    {
        return $this->render('index.html.twig', [
            'galleryImages' => json_encode([]),
        ]);
    }

    /**
     * @Route("/tour/{slug}")
     */
    public function tourAction(Request $request, string $slug): Response
    {
        $tour = $this->tourService->getTourBySlug($slug);

        return $this->render('tour.html.twig', [
            'tour' => $tour,
        ]);
    }

    /**
     * @Route("/tours", name="tour-list")
     */
    public function toursAction(): Response
    {
        return $this->render('tours.html.twig');
    }

    /**
     * @Route("/corporate", name="corporate")
     */
    public function corporateAction(): Response
    {
        return $this->render('corporate.html.twig');
    }
}
