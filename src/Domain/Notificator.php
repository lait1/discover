<?php
declare(strict_types=1);

namespace App\Domain;

use App\Entity\OrderTour;
use App\Infrastructure\TelegramApiClient;
use App\Repository\OrderTourRepository;
use App\Repository\UserRepository;

class Notificator
{
    public TelegramApiClient $apiClient;

    public UserRepository $userRepository;

    public OrderTourRepository $orderTourRepository;

    public function __construct(
        TelegramApiClient $apiClient,
        UserRepository $userRepository,
        OrderTourRepository $orderTourRepository
    ) {
        $this->apiClient = $apiClient;
        $this->userRepository = $userRepository;
        $this->orderTourRepository = $orderTourRepository;
    }

    public function sendNotification(OrderTour $order): void
    {
        $admins = $this->userRepository->findAll();

        foreach ($admins as $admin) {
            if ($admin->getTelegramToken() !== null) {
                $this->apiClient->sendMessage(
                    $admin->getTelegramToken(),
                    $this->buildOrderMessage($order),
                    $order->getId()
                );
            }
        }
    }

    public function sendErrorNotification(string $message): void
    {
        $admin = $this->userRepository->getAdmin();
        if ($admin) {
            return;
        }
        if ($admin->getTelegramToken() !== null) {
            $this->apiClient->sendError(
                $admin->getTelegramToken(),
                $message
            );
        }
    }

    public function answerMessage(int $chatId, string $message): void
    {
        $this->apiClient->answerMessage($chatId, $message);
    }

    private function buildOrderMessage(OrderTour $order): string
    {
        $comment = $order->getComment() ? "<b>Комментарий:</b> {$order->getComment()}" : '';

        if ($order->isUniqTour()) {
            return <<<HTML
            <b>Тур:</b> Уникальный
            <b>Категории:</b> {$order->getSelectedCategory()}
            <b>Хочу дней:</b> {$order->getCountDay()}
            <b>Клиент:</b> {$order->getClient()->getName()}, 
            <b>Группа людей:</b> {$order->getCountPeople()} шт.
            <b>Телефон:</b> {$order->getClient()->getPhone()}
            $comment    
            HTML;
        }
        if ($order->isCorporateTour()) {
            return <<<HTML
            <b>Тур:</b> Корпоративный
            <b>Клиент:</b> {$order->getClient()->getName()}, 
            <b>Группа людей:</b> {$order->getCountPeople()} шт.
            <b>Телефон:</b> {$order->getClient()->getPhone()}
            $comment    
            HTML;
        }

        return <<<HTML
        <b>Тур:</b> {$order->getTour()->getName()}
        <b>Дата бронирования:</b> {$order->getFormattedReservationDate()}
        
        <b>Клиент:</b> {$order->getClient()->getName()}, {$order->getCountPeople()} шт.
        <b>Телефон:</b> {$order->getClient()->getPhone()}
        $comment    
        HTML;
    }
}
