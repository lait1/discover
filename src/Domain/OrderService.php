<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\Model\TelegramMessage;
use App\DTO\OrderDTO;
use App\DTO\OrderMyTourDTO;
use App\Entity\OrderTour;
use App\Entity\ReservationDate;
use App\Entity\User;
use App\Enum\OrderStatusEnum;
use App\Exception\ValidationErrorException;
use App\Repository\CategoryRepository;
use App\Repository\OrderTourRepository;
use App\Repository\ReservationDateRepository;
use App\Repository\TourRepository;
use App\Repository\UserRepository;
use App\View\OrderList;
use App\View\OrderView;
use DateTimeImmutable;
use DateTimeInterface;
use Psr\Log\LoggerInterface;

class OrderService
{
    private OrderTourRepository $orderRepository;

    private TourRepository $tourRepository;

    private Notificator $notificator;

    private ClientService $clientService;

    private CategoryRepository $categoryRepository;

    private ReservationDateRepository $reservationDateRepository;

    private UserRepository $userRepository;

    private LoggerInterface $logger;

    public function __construct(
        OrderTourRepository $orderRepository,
        TourRepository $tourRepository,
        ClientService $clientService,
        Notificator $notificator,
        CategoryRepository $categoryRepository,
        ReservationDateRepository $reservationDateRepository,
        UserRepository $userRepository,
        LoggerInterface $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->tourRepository = $tourRepository;
        $this->clientService = $clientService;
        $this->notificator = $notificator;
        $this->categoryRepository = $categoryRepository;
        $this->reservationDateRepository = $reservationDateRepository;
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    /**
     * @throws ValidationErrorException
     */
    public function bookAnOrder(OrderDTO $dto): void
    {
        $date = $this->getDateTime($dto->date);
        $this->checkAvailableDate($date);

        try {
            $tour = $this->tourRepository->getById($dto->tourId);
            $client = $this->clientService->getOrCreateClient($dto->phone, $dto->name);

            $order = new OrderTour($dto->countPeople, $dto->text);
            $order->setTour($tour);
            $order->setClient($client);
            $order->addReservationDate(new ReservationDate($date));
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
        try {
            $client = $this->clientService->getOrCreateClient($dto->phone, $dto->name);
            $tour = $this->tourRepository->getUniqTour();

            $order = new OrderTour($dto->countPeople, $dto->text);
            $order->setClient($client);
            $order->setTour($tour);
            $order->setCountDay($dto->countDay);
            $order->setDetails($dto->selectedCategories);

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

    public function getUnavailableDates(): array
    {
        $reservationDate = $this->reservationDateRepository->getOrdersOlderToday();

        $dates = ['beforeToday'];
        /** @var ReservationDate $date */
        foreach ($reservationDate as $date) {
            $dates[] = $date->getReservationDate()->format('d/n/Y');
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

    public function approve(int $orderId, User $user): void
    {
        $order = $this->orderRepository->getOrderById($orderId);
        if ($order->isApprove()) {
            throw new \InvalidArgumentException('Заказ уже подтвержден');
        }
        if ($order->isReject()) {
            throw new \InvalidArgumentException('Заказ уже отклонен');
        }

        if (!$order->isUniqTour()) {
            $reservationDates = $order->getReservationDate();
            foreach ($reservationDates->toArray() as $date) {
                $date->setUser($user);
                $this->reservationDateRepository->save($date);
            }
        }
        $order->approve();
        $this->orderRepository->save($order);
    }

    public function reject(int $orderId): void
    {
        $order = $this->orderRepository->getOrderById($orderId);
        if ($order->isReject()) {
            throw new \InvalidArgumentException('Заказ уже отклонен');
        }
        if (!$order->isUniqTour()) {
            $reservationDates = $order->getReservationDate();
            foreach ($reservationDates->toArray() as $date) {
                $this->reservationDateRepository->remove($date);
            }
        }
        $order->reject();
        $this->orderRepository->save($order);
    }

    public function handleTelegramMessage(TelegramMessage $param): void
    {
        $orderId = $param->getCallbackData()->getOrderId();

        $user = $this->userRepository->getUserByToken($param->getCallbackData()->getRecipient());
        try {
            switch ($param->getCallbackData()->getStatus()) {
                case OrderStatusEnum::APPROVE():
                    $this->approve($orderId, $user);
                    $result = 'Тур подтвержден!';
                    break;
                case OrderStatusEnum::REJECT():
                    $this->reject($orderId);
                    $result = 'Тур отклонен :(';
                    break;
                default:
                    throw new \InvalidArgumentException('Status is not supported');
            }
        } catch (\InvalidArgumentException $exception) {
            $result = $exception->getMessage();
        } finally {
            $this->notificator->answerMessage($param->getChatId(), $result);
        }
    }

    private function getDateTime(string $date): DateTimeInterface
    {
        return DateTimeImmutable::createFromFormat('d/m/Y h:i:s', $date . '00:00:00');
    }

    private function checkAvailableDate(DateTimeInterface $date): void
    {
        if ($this->reservationDateRepository->hasOrderSameDate($date)) {
            throw new ValidationErrorException(
                'Просим прощения, эта дата уже зарезервирована! Пожалуйста, выберите другую'
            );
        }
    }
}
