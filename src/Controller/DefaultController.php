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
     * @Route("/", name="main-page")
     */
    public function indexAction(): Response
    {
        return $this->render('index.html.twig', [
            'galleryImages' => json_encode([]),
        ]);
    }

    /**
     * @Route("/admin/", name="app_admin")
     * @Route("/admin/login", name="app_admin_login")
     * @Route("/admin/dashboard", name="app_admin_dashboard")
     * @Route("/admin/tours", name="app_admin_tours")
     * @Route("/admin/orders", name="app_admin_orders")
     * @Route("/admin/tour/{id}/edit", name="app_admin_tour_edit")
     * @Route("/admin/clients", name="app_admin_clients")
     * @Route("/admin/users", name="app_admin_users")
     * @Route("/admin/settings", name="app_admin_settings")
     */
    public function loginAction(): Response
    {
        $this->getUser();

        return $this->render('admin/index.html.twig');
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
