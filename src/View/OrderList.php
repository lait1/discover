<?php
declare(strict_types=1);

namespace App\View;

class OrderList implements \JsonSerializable
{
    private array $order = [];

    public function setReviewView(OrderView $view): void
    {
        $this->order[] = $view;
    }

    public function jsonSerialize(): array
    {
        return $this->order;
    }
}
