<?php
declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static ComplexityEnum HARD()
 * @method static ComplexityEnum MEDIUM()
 * @method static ComplexityEnum EASY()
 */
final class ComplexityEnum extends Enum
{
    public const HARD = 'hard';
    public const MEDIUM = 'medium';
    public const EASY = 'easy';
}
