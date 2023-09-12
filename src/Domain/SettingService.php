<?php
declare(strict_types=1);

namespace App\Domain;

use App\Enum\SettingType;
use App\Repository\SettingRepository;
use App\View\SocialMediaView;

class SettingService
{
    private SettingRepository $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getSocialMedia(): SocialMediaView
    {
        return new SocialMediaView($this->settingRepository->getByType(SettingType::SOCIAL_MEDIA()));
    }
}
