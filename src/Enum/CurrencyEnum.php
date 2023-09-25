<?php
declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static CurrencyEnum USD
 * @method static CurrencyEnum EUR
 * @method static CurrencyEnum RUB
 * @method static CurrencyEnum GEL
 */
class CurrencyEnum extends Enum
{
    public const USD = 'USD';
    public const EUR = 'EUR';
    public const RUB = 'RUB';
    public const GEL = 'GEL';
}
