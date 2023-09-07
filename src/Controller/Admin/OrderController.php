<?php

namespace App\Controller\Admin;

use App\Domain\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractController
{
    private OrderService $orderService;

    private SerializerInterface $serializer;

    public function __construct(
        OrderService $orderService,
        SerializerInterface $serializer
    ) {
        $this->orderService = $orderService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/order/get-orders", methods={"GET"})
     */
    public function getOrdersAction(): Response
    {
        return $this->json($this->orderService->getOrders());
    }
}
