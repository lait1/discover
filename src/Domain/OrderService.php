<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\Model\TelegramMessage;
use App\DTO\OrderDTO;
use App\DTO\OrderMyTourDTO;
use App\Entity\OrderTour;
use App\Enum\OrderStatusEnum;
use App\Exception\ValidationErrorException;
use App\Repository\CategoryRepository;
use App\Repository\OrderTourRepository;
use App\Repository\TourRepository;
use App\View\OrderList;
use App\View\OrderView;
use DateTimeInterface;
use Psr\Log\LoggerInterface;

class OrderService
{
    private OrderTourRepository $orderRepository;

    private TourRepository $tourRepository;

    private Notificator $notificator;

    private ClientService $clientService;

    private CategoryRepository $categoryRepository;

    private LoggerInterface $logger;

    public function __construct(
        OrderTourRepository $orderRepository,
        TourRepository $tourRepository,
        ClientService $clientService,
        Notificator $notificator,
        CategoryRepository $categoryRepository,
        LoggerInterface $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->tourRepository = $tourRepository;
        $this->clientService = $clientService;
        $this->notificator = $notificator;
        $this->categoryRepository = $categoryRepository;
        $this->logger = $logger;
    }

    /**
     * @throws ValidationErrorException
     */
    public function bookAnOrder(OrderDTO $dto): void
    {
        $reservationDate = $this->getDateTime($dto->date);
        $this->checkAvailableDate($reservationDate);

        try {
            $tour = $this->tourRepository->getById($dto->tourId);
            $client = $this->clientService->getOrCreateClient($dto->phone, $dto->name);

            $order = new OrderTour($reservationDate->getTimestamp(), $dto->countPeople, $dto->text);
            $order->setTour($tour);
            $order->setClient($client);

            $this->orderRepository->save($order);

            $this->notificator->sendNotification($order);
        } catch (\Throwable $e) {
            $this->logger->critical(
                'Fail book tour',
                [
                    'message' => $e,
                ]
            );
            $this->notificator->sendErrorNotification($e->getMessage());
        }
    }

    public function bookMyTour(OrderMyTourDTO $dto): void
    {
        $client = $this->clientService->getOrCreateClient($dto->phone, $dto->name);
        $tour = $this->tourRepository->getUniqTour();

        $order = new OrderTour(time(), $dto->countPeople, $dto->text);
        $order->setClient($client);
        $order->setTour($tour);
        $order->setCountDay($dto->countDay);
        $order->setDetails($dto->selectedCategories);

        $this->orderRepository->save($order);

        $this->notificator->sendNotification($order);
    }

    public function getUnavailableDates(): array
    {
        $orders = $this->orderRepository->getOrdersOlderToday();
        $dates = ['beforeToday'];
        /** @var OrderTour $order */
        foreach ($orders as $order) {
            $dates[] = $order->getReservationDate()->format('d/n/Y');
        }

        return $dates;
    }

    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function getOrders(): OrderList
    {
        $list = new OrderList();
        foreach ($this->orderRepository->getAllOrders() as $order) {
            $list->setOrderView(new OrderView($order));
        }

        return $list;
    }

    public function approve(int $orderId): void
    {
        $order = $this->orderRepository->getOrderById($orderId);
        $order->approve();

        $this->orderRepository->save($order);
    }

    public function reject(int $orderId): void
    {
        $order = $this->orderRepository->getOrderById($orderId);
        $order->reject();

        $this->orderRepository->save($order);
    }

    public function handleTelegramMessage(TelegramMessage $param): void
    {
        $status = $param->getCallbackData()->getStatus();
        $orderId = $param->getCallbackData()->getOrderId();

        switch ($status) {
            case OrderStatusEnum::APPROVE():
                $this->approve($orderId);
                $result = 'Тур подтвержден!';
                break;
            case OrderStatusEnum::REJECT():
                $this->reject($orderId);
                $result = 'Тур отклонен :(';
                break;
            default:
                throw new \InvalidArgumentException('Status is not supported');
        }
        $this->notificator->answerMessage($param->getChatId(), $result);
    }

    private function getDateTime(string $date): DateTimeInterface
    {
        return \DateTimeImmutable::createFromFormat('d/m/Y h:i:s', $date . '00:00:00');
    }

    private function checkAvailableDate(DateTimeInterface $date): void
    {
        if ($this->orderRepository->hasOrderSameDate($date->getTimestamp())) {
            throw new ValidationErrorException(
                'Просим прощения, эта дата уже зарезервирована! Пожалуйста, выберите другую'
            );
        }
    }
}
