<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Domain\OrderService;
use App\DTO\OrderActionDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/order/approve", methods={"POST"})
     */
    public function approveAction(Request $request): Response
    {
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            OrderActionDTO::class,
            'json'
        );

        try {
            $this->orderService->approve($dto->id, $this->getUser());

            return $this->json(['message' => 'success']);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/order/reject", methods={"POST"})
     */
    public function rejectAction(Request $request): Response
    {
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            OrderActionDTO::class,
            'json'
        );

        try {
            $this->orderService->reject($dto->id);

            return $this->json(['message' => 'success']);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
