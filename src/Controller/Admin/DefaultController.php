<?php

namespace App\Controller\Admin;

use App\Domain\TourService;
use App\Domain\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends AbstractController
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
     * @Route("/get-options", methods={"GET"})
     */
    public function getOptionsAction(): Response
    {
        return $this->json($this->tourService->getOptions());
    }
}
