<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\SettingService;
use App\Domain\TourService;
use App\Repository\TourOptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private TourService $tourService;

    private SettingService $settingService;

    private TourOptionRepository $tourOptionRepository;

    public function __construct(
        TourService $tourService,
        SettingService $settingService,
        TourOptionRepository $tourOptionRepository
    ) {
        $this->tourService = $tourService;
        $this->settingService = $settingService;
        $this->tourOptionRepository = $tourOptionRepository;
    }

    /**
     * @Route("/", name="main-page")
     */
    public function indexAction(): Response
    {
        return $this->render('index.html.twig', [
            'tours'  => $this->tourService->getPublicTours(),
            'social' => $this->settingService->getSocialMedia(),
            'email'  => $this->settingService->getEmailMedia(),
            'photos' => $this->settingService->getGalleryMainPage(),
        ]);
    }

    /**
     * @Route("/admin/", name="app_admin")
     * @Route("/admin/login", name="app_admin_login")
     * @Route("/admin/dashboard", name="app_admin_dashboard")
     * @Route("/admin/tours", name="app_admin_tours")
     * @Route("/admin/profile", name="app_admin_profile")
     * @Route("/admin/tour/{id}/edit", name="app_admin_tour_edit")
     * @Route("/admin/orders", name="app_admin_orders")
     * @Route("/admin/comments", name="app_admin_comments")
     * @Route("/admin/clients", name="app_admin_clients")
     * @Route("/admin/users", name="app_admin_users")
     * @Route("/admin/user/{id}/edit", name="app_admin_user_edit")
     * @Route("/admin/user/form", name="app_admin_user_create")
     * @Route("/admin/settings", name="app_admin_settings")
     */
    public function loginAction(): Response
    {
        $this->getUser();

        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/tour/{slug}", name="tour-view")
     */
    public function tourAction(Request $request, string $slug): Response
    {
        $tour = $this->tourService->getTourBySlug($slug);

        return $this->render('tour.html.twig', [
            'tour'         => $tour,
            'social'       => $this->settingService->getSocialMedia(),
            'email'        => $this->settingService->getEmailMedia(),
            'includePrice' => $this->tourOptionRepository->getByIds($tour->getIncludePriceDetails()),
            'excludePrice' => $this->tourOptionRepository->getByIds($tour->getExcludePriceDetails()),
        ]);
    }

    /**
     * @Route("/tours", name="tour-list")
     */
    public function toursAction(): Response
    {
        return $this->render('tours.html.twig', [
            'social' => $this->settingService->getSocialMedia(),
            'email'  => $this->settingService->getEmailMedia(),
            'tours'  => $this->tourService->getPublicTours(),
        ]);
    }

    /**
     * @Route("/privacy", name="privacy")
     */
    public function privacyAction(): Response
    {
        return $this->render('privacy.html.twig', [
            'social' => $this->settingService->getSocialMedia(),
            'email'  => $this->settingService->getEmailMedia(),
        ]);
    }

    /**
     * @Route("/tour/get-price/{id}", methods={"GET"})
     */
    public function getCategoriesAction(int $id): Response
    {
        return $this->json($this->tourService->getPriceByTourId($id));
    }

    /**
     * @Route("/corporate", name="corporate")
     */
    public function corporateAction(): Response
    {
        return $this->render('corporate.html.twig', [
            'social' => $this->settingService->getSocialMedia(),
            'email'  => $this->settingService->getEmailMedia(),
            'photos' => $this->settingService->getGalleryCorporate(),
        ]);
    }
}
