<?php
declare(strict_types=1);

namespace App\Domain;

use App\DTO\OrderDTO;
use App\Repository\ClientRepository;
use App\Repository\OrderRepository;
use App\Repository\TourRepository;

class OrderService
{
    public OrderRepository $orderRepository;

    public TourRepository $tourRepository;

    public ClientRepository $clientRepository;

    public function __construct(
        OrderRepository $orderRepository,
        TourRepository $tourRepository,
        ClientRepository $clientRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->tourRepository = $tourRepository;
        $this->clientRepository = $clientRepository;
    }

    public function bookAnOrder(OrderDTO $dto): void
    {
    }
}
