<?php
declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self SOCIAL_MEDIA()
 * @method static self PHONE()
 * @method static self EMAIL()
 */
final class SettingType extends Enum
{
    public const SOCIAL_MEDIA = 'social_media';
    public const PHONE = 'phone';
    public const EMAIL = 'email';
}
