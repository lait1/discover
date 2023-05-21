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
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/tours")
     */
    public function toursAction(): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/corporate")
     */
    public function corporateAction(): Response
    {
        return $this->render('index.html.twig');
    }
}
