<?php

namespace App\Infrastructure;

use TelegramBot\Api\BotApi;

class TelegramApiClient
{
    private BotApi $telegramBot;

    public function __construct(string $telegramToken)
    {
        $this->telegramBot = new BotApi($telegramToken);
    }

    public function sendMessage(string $recipient, string $message): void
    {
        $this->telegramBot->sendMessage(
            $recipient,
            $message,
            'HTML',
        );
    }
}
