<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Domain\SettingService;
use App\DTO\SettingUpdateDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SettingController extends AbstractController
{
    private SettingService $settingService;

    private SerializerInterface $serializer;

    public function __construct(
        SettingService $settingService,
        SerializerInterface $serializer
    ) {
        $this->settingService = $settingService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/setting/get-settings", methods={"GET"})
     */
    public function getSettingsAction(): Response
    {
        return $this->json($this->settingService->getSettings());
    }

    /**
     * @Route("/setting/update", methods={"POST"})
     */
    public function updateAction(Request $request): Response
    {
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            SettingUpdateDTO::class,
            'json'
        );

        try {
            $this->settingService->update($dto);

            return $this->json(['message' => 'success']);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
