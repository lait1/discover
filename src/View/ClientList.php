<?php
declare(strict_types=1);

namespace App\View;

class ClientList implements \JsonSerializable
{
    private array $client = [];

    public function setClientView(ClientView $view): void
    {
        $this->client[] = $view;
    }

    public function jsonSerialize(): array
    {
        return $this->client;
    }
}
