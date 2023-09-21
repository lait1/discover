<?php
declare(strict_types=1);

namespace App\Domain\Model;

class TelegramMessage
{
    public array $data;

    public function __construct(array $data)
    {
        if (!isset($data['callback_query'])) {
            throw new \InvalidArgumentException('Wrong data');
        }
        $this->data = $data['callback_query'];
    }

    public function getChatId(): int
    {
        return (int) $this->data['id'];
    }

    public function getCallbackData(): CallbackData
    {
        return CallbackData::buildRawData(json_decode($this->data['data'], true));
    }
}
