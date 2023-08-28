<?php

namespace App\Infrastructure;

use TelegramBot\Api\BotApi;

class TelegramApiClient
{
    private BotApi $telegramBot;

    private BotApi $telegramErrorChannel;

    public function __construct(string $telegramToken, string $telegramErrorChannelToken)
    {
        $this->telegramBot = new BotApi($telegramToken);
        $this->telegramErrorChannel = new BotApi($telegramErrorChannelToken);
    }

    public function sendMessage(string $recipient, string $message): void
    {
        $this->telegramBot->sendMessage(
            $recipient,
            $message,
            'HTML',
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
