<?php

namespace App\Infrastructure;

use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

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
        $keyboard = new InlineKeyboardMarkup(
            [
                [
                    ['text' => 'Подтвердить', 'callback_data' => '{"action":"result","training_id":1,"text":"I`m tired"}'],
                    ['text' => 'Отказать', 'callback_data' => '{"action":"result","training_id":1,"text":"Done"}'],
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
