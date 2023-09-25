<?php
declare(strict_types=1);

namespace App\View;

class PriceView implements \JsonSerializable
{
    private array $price = [];

    public function __construct(int $price, string $currency)
    {
        $this->price[] = [
            'price'    => $price,
            'currency' => $currency,
        ];
    }

    public function setRates(int $price, string $currency): void
    {
        $this->price[] = [
            'price'    => $price,
            'currency' => $currency,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->price;
    }
}
