<?php

namespace App\Admin\Infrastructure\DataFixtures;

use App\Admin\Domain\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    private EntityManagerInterface $em;

    public function __construct(UserPasswordHasherInterface $encoder, EntityManagerInterface $entityManager)
    {
        $this->encoder = $encoder;
        $this->em = $entityManager;
    }

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        $usersData = [
            0 => [
                'email' => 'admin@example.com',
                'role' => ['ROLE_USER'],
                'password' => 123123
            ],
            1 => [
                'email' => 'user@example.com',
                'role' => ['ROLE_USER'],
                'password' => 123123
            ],
        ];

        foreach ($usersData as $user) {
            $newUser = new User();
            $newUser->setEmail($user['email']);
            $newUser->setPassword($this->encoder->hashPassword($newUser, $user['password']));
            $newUser->setRoles($user['role']);
            $this->em->persist($newUser);
        }

        $this->em->flush();
    }
}
