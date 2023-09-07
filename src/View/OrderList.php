<?php
declare(strict_types=1);

namespace App\View;

class OrderList implements \JsonSerializable
{
    private array $order = [];

    public function setOrderView(OrderView $view): void
    {
        $this->order[] = $view;
    }

    public function jsonSerialize(): array
    {
        return $this->order;
    }
}
