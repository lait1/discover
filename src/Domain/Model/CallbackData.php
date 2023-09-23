<?php
declare(strict_types=1);

namespace App\Domain\Model;

use App\Enum\OrderStatusEnum;

class CallbackData implements \JsonSerializable
{
    private OrderStatusEnum $status;

    private string $recipient;

    private int $orderId;

    private function __construct(OrderStatusEnum $status, string $recipient, int $orderId)
    {
        $this->status = $status;
        $this->recipient = $recipient;
        $this->orderId = $orderId;
    }

    public static function buildRawData(array $data): self
    {
        $status = new OrderStatusEnum($data['status']);

        return new self($status, $data['recipient'], $data['orderId']);
    }

    public static function buildApproveData(string $recipient, int $orderId): self
    {
        return new self(OrderStatusEnum::APPROVE(), $recipient, $orderId);
    }

    public static function buildRejectData(string $recipient, int $orderId): self
    {
        return new self(OrderStatusEnum::REJECT(), $recipient, $orderId);
    }

    public function jsonSerialize(): array
    {
        return [
            'orderId'   => $this->orderId,
            'recipient' => $this->recipient,
            'status'    => $this->status->getValue(),
        ];
    }

    public function getStatus(): OrderStatusEnum
    {
        return $this->status;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }
}
