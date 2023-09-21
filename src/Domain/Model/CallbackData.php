<?php
declare(strict_types=1);

namespace App\Domain\Model;

use App\Enum\OrderStatusEnum;

class CallbackData implements \JsonSerializable
{
    private OrderStatusEnum $status;

    private int $orderId;

    private function __construct(OrderStatusEnum $status, int $orderId)
    {
        $this->status = $status;
        $this->orderId = $orderId;
    }

    public static function buildRawData(array $data): self
    {
        $status = new OrderStatusEnum($data['status']);

        return new self($status, $data['orderId']);
    }

    public static function buildApproveData(int $orderId): self
    {
        return new self(OrderStatusEnum::APPROVE(), $orderId);
    }

    public static function buildRejectData(int $orderId): self
    {
        return new self(OrderStatusEnum::REJECT(), $orderId);
    }

    public function jsonSerialize(): array
    {
        return [
            'orderId' => $this->orderId,
            'status'  => $this->status->getValue(),
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
}
