<?php

namespace App\Infrastructure;

use App\Domain\Model\CallbackData;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class TelegramApiClient
{
    private BotApi $telegramBot;

    private BotApi $telegramErrorChannel;

    public function __construct(
        string $telegramToken,
        string $telegramErrorChannelToken,
        string $siteUrl
    ) {
        $this->telegramBot = new BotApi($telegramToken);
        $this->telegramBot->setWebhook($siteUrl);
        $this->telegramErrorChannel = new BotApi($telegramErrorChannelToken);
    }

    public function sendMessage(string $recipient, string $message, int $tourId): void
    {
        $keyboard = new InlineKeyboardMarkup(
            [
                [
                    ['text' => 'Подтвердить', 'callback_data' => CallbackData::buildApproveData($tourId)],
                    ['text' => 'Отказать', 'callback_data' => CallbackData::buildRejectData($tourId)],
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

    public function sendError(string $recipient, string $error): void
    {
        $this->telegramErrorChannel->sendMessage(
            $recipient,
            $error,
            'HTML',
        );
    }
}
