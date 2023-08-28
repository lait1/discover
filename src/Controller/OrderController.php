<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\OrderService;
use App\DTO\OrderDTO;
use App\Exception\ValidationErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractController
{
    private OrderService $orderService;

    private SerializerInterface $serializer;

    public function __construct(OrderService $orderService, SerializerInterface $serializer)
    {
        $this->orderService = $orderService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/order/reservation", name="reservation-order", methods={"POST"})
     */
    public function addCommentAction(Request $request): Response
    {
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            OrderDTO::class,
            'json'
        );
        try {
            $this->orderService->bookAnOrder($dto);
            throw new \Exception('qweqwe');

            return $this->json(['message' => 'success']);
        } catch (ValidationErrorException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
