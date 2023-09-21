<?php

namespace App\Infrastructure;

use App\Application\Router;
use App\Domain\Model\CallbackData;
use Psr\Log\LoggerInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class TelegramApiClient
{
    private BotApi $telegramBot;

    private BotApi $telegramErrorChannel;

    private Router $router;

    private LoggerInterface $logger;

    public function __construct(
        Router $router,
        LoggerInterface $logger,
        string $telegramToken,
        string $telegramErrorChannelToken
    ) {
        $this->telegramBot = new BotApi($telegramToken);
        $this->telegramErrorChannel = new BotApi($telegramErrorChannelToken);
        $this->router = $router;
        $this->logger = $logger;
        $this->telegramBot->setWebhook($router->generate('telegram-webhook'));
    }

    public function sendMessage(string $recipient, string $message, int $tourId): void
    {
        $keyboard = new InlineKeyboardMarkup(
            [
                [
                    ['text' => 'Подтвердить', 'callback_data' => json_encode(CallbackData::buildApproveData($tourId))],
                    ['text' => 'Отказать', 'callback_data' => json_encode(CallbackData::buildRejectData($tourId))],
                ],
            ]
        );

        $this->telegramBot->sendMessage(
            $recipient,
            $message,
            'HTML',
            true,
            null,
            $keyboard
        );
    }

    public function answerMessage(int $chatId, string $message): void
    {
        $this->telegramBot->answerCallbackQuery($chatId, $message, true);
    }

    public function sendError(string $recipient, string $error): void
    {
        $this->telegramErrorChannel->sendMessage(
            $recipient,
            $error,
            'HTML',
        );
    }
}
