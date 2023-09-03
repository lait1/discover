<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\OrderService;
use App\DTO\OrderDTO;
use App\Exception\ValidationErrorException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractController
{
    private OrderService $orderService;

    private SerializerInterface $serializer;

    private LoggerInterface $logger;

    public function __construct(
        OrderService $orderService,
        SerializerInterface $serializer,
        LoggerInterface $logger
    ) {
        $this->orderService = $orderService;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * @Route("/order/reservation", name="reservation-order", methods={"POST"})
     */
    public function reservationAction(Request $request): Response
    {
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            OrderDTO::class,
            'json'
        );
        try {
            $this->orderService->bookAnOrder($dto);

            return $this->json(['message' => 'success']);
        } catch (ValidationErrorException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/order/get-unavailable-dates", name="unavailable-dates", methods={"GET"})
     */
    public function getUnavailableDates(): Response
    {
        try {
            return $this->json($this->orderService->getUnavailableDates());
        } catch (ValidationErrorException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/telegram/webhook", name="telegram-webhook")
     */
    public function webhookAction(Request $request): Response
    {
        $postParams = $request->request->all();
        $getParams = $request->query->all();
        $content = $request->getContent() ?: '';

        $this->logger->info('From telegram', [
            'method'  => $request->getMethod(),
            'post'    => $postParams,
            'get'     => $getParams,
            'content' => $content,
        ]);

        return new Response();
    }
}
