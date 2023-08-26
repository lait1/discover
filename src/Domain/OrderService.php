<?php
declare(strict_types=1);

namespace App\Domain;

use App\DTO\OrderDTO;
use App\Entity\Client;
use App\Entity\OrderTour;
use App\Repository\ClientRepository;
use App\Repository\OrderTourRepository;
use App\Repository\TourRepository;

class OrderService
{
    public OrderTourRepository $orderRepository;

    public TourRepository $tourRepository;

    public ClientRepository $clientRepository;

    public Notificator $notificator;

    public function __construct(
        OrderTourRepository $orderRepository,
        TourRepository $tourRepository,
        ClientRepository $clientRepository,
        Notificator $notificator
    ) {
        $this->orderRepository = $orderRepository;
        $this->tourRepository = $tourRepository;
        $this->clientRepository = $clientRepository;
        $this->notificator = $notificator;
    }

    public function bookAnOrder(OrderDTO $dto): void
    {
        $client = $this->clientRepository->findClientByPhone($dto->phone);
        if ($client === null) {
            $client = new Client($dto->phone, $dto->name);
            $client->setPassword(Client::DEFAULT_PASSWORD);
            $this->clientRepository->save($client);
        }
        $tour = $this->tourRepository->getById($dto->tourId);
        $reservationDate = \DateTimeImmutable::createFromFormat('d/m/Y h:i:s', $dto->date . '00:00:00');

        $order = new OrderTour($reservationDate->getTimestamp(), $dto->countPeople, $dto->text);
        $order->setTour($tour);
        $order->setClient($client);

        $this->orderRepository->save($order);

        $this->notificator->sendNotification($order);
    }
}
