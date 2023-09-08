<?php

namespace App\Controller\Admin;

use App\Domain\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private UserService $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * @Route("/user/get-users", methods={"GET"})
     */
    public function getUsersAction(): Response
    {
        return $this->json($this->userService->getAllUsers());
    }
}
