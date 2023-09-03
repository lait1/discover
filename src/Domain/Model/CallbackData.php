<?php
declare(strict_types=1);

namespace App\Domain\Model;

use App\Enum\OrderStatusEnum;

class CallbackData implements \JsonSerializable
{
    private OrderStatusEnum $status;

    private int $tourId;

    private string $hash;

    private function __construct(OrderStatusEnum $status, int $tourId)
    {
        $this->status = $status->getValue();
        $this->tourId = $tourId;
    }

    public static function buildApproveData(int $tourId): self
    {
        return new self(OrderStatusEnum::APPROVE(), $tourId);
    }

    public static function buildRejectData(int $tourId): self
    {
        return new self(OrderStatusEnum::REJECT(), $tourId);
    }

    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    public function jsonSerialize(): array
    {
        return [
            'tourId' => $this->tourId,
            'status' => $this->status,
            'hash'   => $this->hash,
        ];
    }
}
