<?php
declare(strict_types=1);

namespace App\View;

class TourList implements \JsonSerializable
{
    private array $tours = [];

    public function setTourView(TourView $view): void
    {
        $this->tours[] = $view;
    }

    public function jsonSerialize(): array
    {
        return $this->tours;
    }
}
