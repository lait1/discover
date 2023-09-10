<?php
declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self INCLUDE()
 * @method static self EXCLUDE()
 */
final class PriceDetailsTypeEnum extends Enum
{
    public const INCLUDE = 'include';
    public const EXCLUDE = 'exclude';
}
