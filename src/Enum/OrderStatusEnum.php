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
    public const WAIT = 'wait';
    public const APPROVE = 'approve';
    public const REJECT = 'reject';
}
