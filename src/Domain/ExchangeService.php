<?php
declare(strict_types=1);

namespace App\Domain;

use App\Repository\ExchangeRateRepository;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class ExchangeService
{
    private string $rateUrl;

    private string $content;

    private ExchangeRateRepository $exchangeRepository;

    private LoggerInterface $logger;

    public function __construct(
        string $rateUrl,
        ExchangeRateRepository $exchangeRepository,
        LoggerInterface $logger
    ) {
        $this->rateUrl = $rateUrl;
        $this->exchangeRepository = $exchangeRepository;
        $this->logger = $logger;
    }

    public function parseExchange(): void
    {
        try {
            $this->content = $this->getUrlContent($this->rateUrl);

            $rates = $this->exchangeRepository->findAll();
            $result = [];

            foreach ($rates as $rate) {
                $result[$rate->getSymbol()] = $this->getRate($rate->getPattern());
            }

            $this->loadRate($result);
        } catch (\Throwable $e) {
            $this->logger->critical(
                'Fail get exchange rates',
                [
                    'message' => $e,
                ]
            );
        }
    }

    public function calculate(int $getPrice): array
    {
        $result = [];
        foreach ($this->exchangeRepository->findAll() as $rate) {
            $result[$rate->getSymbol()] = (int) ((float) $rate->getRate() * $getPrice);
        }

        return $result;
    }

    private function loadRate(array $result): void
    {
        foreach ($result as $symbol => $externalRate) {
            $rate = $this->exchangeRepository->find($symbol);
            $rate->setRate($externalRate);
            $this->exchangeRepository->save($rate);
        }
    }

    private function getRate(string $pattern): string
    {
        $match = false;
        if (!preg_match('!' . $pattern . '!', $this->content, $match)) {
            throw new \Exception('Unable to parse quotes', 500);
        }

        return $match[1];
    }

    private function getUrlContent(string $url): string
    {
        $options = [
            'verify'  => false,
            'timeout' => 10,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.146 Safari/537.36',
            ],
        ];

        $client = new Client();
        $response = $client->request('GET', $url, $options);

        return $response->getBody()->getContents();
    }
}
