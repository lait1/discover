<?php
declare(strict_types=1);

namespace App\Domain;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientService
{
    private ClientRepository $clientRepository;

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(ClientRepository $clientRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->clientRepository = $clientRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function getOrCreateClient(string $phone, string $name): Client
    {
        $client = $this->clientRepository->findClientByPhone($phone);
        if ($client === null) {
            $client = new Client($phone, $name);
            $hashPassword = $this->passwordHasher->hashPassword($client, Client::DEFAULT_PASSWORD);
            $client->setPassword($hashPassword);
            $this->clientRepository->save($client);
        }

        return $client;
    }
}
