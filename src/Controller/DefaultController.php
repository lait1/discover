<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function indexAction(): Response
    {
        return $this->render('index.html.twig', [
            'galleryImages' => json_encode([
                'build/images/photos/photo1.jpeg',
                'build/images/photos/photo2.jpeg',
                'build/images/photos/photo.png',
                'build/images/photos/photo3.jpeg',
            ]),
        ]);
    }

    /**
     * @Route("/tour/{slug}")
     */
    public function tourAction(): Response
    {
        return $this->render('trip.html.twig');
    }

    /**
     * @Route("/tours", name="tour-list")
     */
    public function toursAction(): Response
    {
        return $this->render('trips.html.twig');
    }

    /**
     * @Route("/corporate", name="corporate")
     */
    public function corporateAction(): Response
    {
        return $this->render('corporate.html.twig');
    }

    /**
     * @Route("/about", name="about-us")
     */
    public function aboutAction(): Response
    {
        return $this->render('about.html.twig');
    }
}
