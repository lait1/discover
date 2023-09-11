<?php
declare(strict_types=1);

namespace App\Domain;

use App\DTO\UserCreateDTO;
use App\DTO\UserEditDTO;
use App\Entity\User;
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

    public function getUserById(int $id): UserView
    {
        return new UserView($this->userRepository->getUserById($id));
    }

    public function createUser(UserCreateDTO $dto): void
    {
        $newUser = new User();
        $newUser->setEmail($dto->email);
        $newUser->setPassword($this->passwordHasher->hashPassword($newUser, $dto->password));
        $newUser->setRoles($dto->role);
        $newUser->setTelegramToken($dto->telegramToken);

        $this->userRepository->add($newUser, true);
    }

    public function editUser(UserEditDTO $dto): void
    {
        $user = $this->userRepository->getUserById($dto->id);
        $user->setEmail($dto->email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $dto->password));
        $user->setRoles($dto->role);
        $user->setTelegramToken($dto->telegramToken);

        $this->userRepository->add($user, true);
    }
}
