<?php
declare(strict_types=1);

namespace App\Domain;

use App\Repository\UserRepository;
use App\View\UserList;
use App\View\UserView;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserRepository $userRepository;

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function getAllUsers(): UserList
    {
        $list = new UserList();

        foreach ($this->userRepository->getAllUsers() as $user) {
            $list->setUserView(new UserView($user));
        }

        return $list;
    }
}
