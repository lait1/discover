<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\Model\TelegramMessage;
use App\Domain\OrderService;
use App\DTO\OrderCorporateDTO;
use App\DTO\OrderDTO;
use App\DTO\OrderMyTourDTO;
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
            $this->logger->critical(
                'Failed reservation tour',
                [
                    'error' => $e,
                ]
            );

            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/order/make-my-tour", name="make-my-tour", methods={"POST"})
     */
    public function makeMyTourAction(Request $request): Response
    {
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            OrderMyTourDTO::class,
            'json'
        );
        try {
            $this->orderService->bookMyTour($dto);

            return $this->json(['message' => 'success']);
        } catch (\Throwable $e) {
            $this->logger->critical(
                'Failed make uniq tour',
                [
                    'error' => $e,
                ]
            );

            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/order/book-corporate", name="book-corporate", methods={"POST"})
     */
    public function corporateAction(Request $request): Response
    {
        $dto = $this->serializer->deserialize(
            $request->getContent(),
            OrderCorporateDTO::class,
            'json'
        );
        try {
            $this->orderService->bookCorporateTour($dto);

            return $this->json(['message' => 'success']);
        } catch (\Throwable $e) {
            $this->logger->critical(
                'Failed make uniq tour',
                [
                    'error' => $e,
                ]
            );

            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/order/get-categories", methods={"GET"})
     */
    public function getCategoriesAction(): Response
    {
        return $this->json($this->orderService->getCategories());
    }

    /**
     * @Route("/order/get-unavailable-dates", name="unavailable-dates", methods={"GET"})
     */
    public function getUnavailableDates(): Response
    {
        try {
            return $this->json($this->orderService->getUnavailableDates());
        } catch (\Throwable $e) {
            $this->logger->critical(
                'Failed get unavailable dates',
                [
                    'error' => $e,
                ]
            );

            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @Route("/telegram/webhook", name="telegram-webhook")
     */
    public function webhookAction(Request $request): Response
    {
        $content = $request->getContent() ?: '';

        $this->logger->info(
            'Telegram: Message received',
            [
                'headers' => $request->headers->keys(),
                'message' => $content,
            ]
        );
        try {
            $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            $this->orderService->handleTelegramMessage(new TelegramMessage($data));
        } catch (\Throwable $e) {
            $this->logger->critical(
                'Can not get update from telegram',
                [
                    'error' => $e,
                    'data'  => $content,
                ]
            );

            return new Response();
        }

        return new Response('ok');
    }
}
