<?php
declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\Router;
use App\Domain\Model\CallbackData;
use Psr\Log\LoggerInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class TelegramApiClient
{
    private string $telegramToken;

    private string $telegramErrorChannelToken;

    private Router $router;

    private LoggerInterface $logger;

    public function __construct(
        Router $router,
        LoggerInterface $logger,
        string $telegramToken,
        string $telegramErrorChannelToken
    ) {
        $this->telegramToken = $telegramToken;
        $this->telegramErrorChannelToken = $telegramErrorChannelToken;
        $this->router = $router;
        $this->logger = $logger;
    }

    public function sendMessage(string $recipient, string $message, int $orderId): void
    {
        $telegramBot = new BotApi($this->telegramToken);
        $telegramBot->setWebhook($this->router->generate('telegram-webhook'));

        $keyboard = new InlineKeyboardMarkup(
            [
                [
                    ['text' => 'Подтвердить', 'callback_data' => json_encode(CallbackData::buildApproveData($recipient, $orderId))],
                    ['text' => 'Отказать', 'callback_data' => json_encode(CallbackData::buildRejectData($recipient, $orderId))],
                ],
            ]
        );

        $telegramBot->sendMessage(
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
        $telegramBot = new BotApi($this->telegramToken);
        $telegramBot->answerCallbackQuery($chatId, $message, true);
    }

    public function sendError(string $recipient, string $error): void
    {
        $telegramErrorChannel = new BotApi($this->telegramErrorChannelToken);
        $telegramErrorChannel->sendMessage(
            $recipient,
            $error,
            'HTML',
        );
    }
}
