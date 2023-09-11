<?php

namespace App\Controller\Admin;

use App\Domain\UserService;
use App\DTO\UserCreateDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    private UserService $userService;

    private SerializerInterface $serializer;

    public function __construct(
        UserService $userService,
        SerializerInterface $serializer
    ) {
        $this->userService = $userService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/user/get-users", methods={"GET"})
     */
    public function getUsersAction(): Response
    {
        return $this->json($this->userService->getAllUsers());
    }

    /**
     * @Route("/user/create", methods={"POST"})
     */
    public function createAction(Request $request): Response
    {
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            UserCreateDTO::class,
            'json'
        );
        try {
            $this->userService->createUser($dto);

            return $this->json(['message' => 'success']);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
