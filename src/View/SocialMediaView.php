<?php
declare(strict_types=1);

namespace App\View;

use App\Entity\Setting;
use App\Enum\SocialMediaType;

class SocialMediaView
{
    private array $media;

    public function __construct(array $media)
    {
        $this->media = $media;
    }

     public function getTwitter(): string
     {
         return $this->getValueByType(SocialMediaType::TWITTER());
     }

    public function getTelegram(): string
    {
        return $this->getValueByType(SocialMediaType::TELEGRAM());
    }

    public function getWhatsapp(): string
    {
        return $this->getValueByType(SocialMediaType::WHATSAPP());
    }

    public function getYoutube(): string
    {
        return $this->getValueByType(SocialMediaType::YOUTUBE());
    }

    public function getInstagram(): string
    {
        return $this->getValueByType(SocialMediaType::INSTAGRAM());
    }

    private function getValueByType(SocialMediaType $type): string
    {
        $result = array_filter($this->media, function (Setting $setting) use ($type) {
            return $setting->getName() === $type->getValue();
        });
        if ($result) {
            $setting = array_shift($result);

            return $setting->getValue();
        }

        return 'https://www.google.com/';
    }
}
