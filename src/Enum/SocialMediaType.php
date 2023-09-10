<?php
declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self TWITTER()
 * @method static self TELEGRAM()
 * @method static self WHATSAPP()
 * @method static self YOUTUBE()
 * @method static self INSTAGRAM()
 */
final class SocialMediaType extends Enum
{
    public const TWITTER = 'twitter';
    public const TELEGRAM = 'telegram';
    public const WHATSAPP = 'whatsapp';
    public const YOUTUBE = 'youtube';
    public const INSTAGRAM = 'instagram';
}
