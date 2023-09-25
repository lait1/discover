<?php
declare(strict_types=1);

namespace App\Entity;

use App\Enum\CurrencyEnum;
use App\Repository\ExchangeRateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExchangeRateRepository::class)
 */
class ExchangeRate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=21)
     */
    private string $symbol;

    /** @ORM\Column(type="string", length=10) */
    private string $rate;

    /** @ORM\Column(type="string") */
    private string $pattern;

    /** @ORM\Column(type="integer", options={"unsigned": true}) */
    private int $updated;

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getMainCurrency(): string
    {
        return explode('/', $this->symbol)[1];
    }

    public function getMainCurrencyEnum(): CurrencyEnum
    {
        return new CurrencyEnum($this->getMainCurrency());
    }

    public function getUpdated(): int
    {
        return $this->updated;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getRate(): string
    {
        return $this->rate;
    }

    public function setRate(string $rate): void
    {
        $rate = round(1 / $rate, 4);
        if ($this->symbol === CurrencyEnum::RUB) {
            $rate = $rate * 100;
        }

        $this->rate = (string) $rate;
        $this->updated = time();
    }
}
