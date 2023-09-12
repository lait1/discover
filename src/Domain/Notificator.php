<?php
declare(strict_types=1);

namespace App\Domain;

use App\Entity\OrderTour;
use App\Infrastructure\TelegramApiClient;
use App\Repository\UserRepository;

class Notificator
{
    public TelegramApiClient $apiClient;

    public UserRepository $userRepository;

    public function __construct(TelegramApiClient $apiClient, UserRepository $userRepository)
    {
        $this->apiClient = $apiClient;
        $this->userRepository = $userRepository;
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

        if ($admin->getTelegramToken() !== null) {
            $this->apiClient->sendError(
                $admin->getTelegramToken(),
                $message
            );
        }
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

        return <<<HTML
        <b>Тур:</b> {$order->getTour()->getName()}
        <b>Дата бронирования:</b> {$order->getFormattedReservationDate()}
        
        <b>Клиент:</b> {$order->getClient()->getName()}, {$order->getCountPeople()} шт.
        <b>Телефон:</b> {$order->getClient()->getPhone()}
        $comment    
        HTML;
    }
}
