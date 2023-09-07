<?php
declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static OrderStatusEnum WAIT()
 * @method static OrderStatusEnum APPROVE()
 * @method static OrderStatusEnum REJECT()
 */
final class OrderStatusEnum extends Enum
{
    public const WAIT = 'WAIT';
    public const APPROVE = 'APPROVE';
    public const REJECT = 'REJECT';
}
