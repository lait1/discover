<?php
declare(strict_types=1);

namespace App\Domain;

use App\DTO\SettingUpdateDTO;
use App\Entity\Setting;
use App\Enum\SettingType;
use App\Enum\SocialMediaType;
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

    public function update(SettingUpdateDTO $dto): void
    {
        $list = [];
        $list[] = $this->findOrCreate(SocialMediaType::TELEGRAM()->getValue(), $dto->telegram);
        $list[] = $this->findOrCreate(SocialMediaType::TWITTER()->getValue(), $dto->twitter);
        $list[] = $this->findOrCreate(SocialMediaType::INSTAGRAM()->getValue(), $dto->instagram);
        $list[] = $this->findOrCreate(SocialMediaType::WHATSAPP()->getValue(), $dto->whatsapp);
        $list[] = $this->findOrCreate(SocialMediaType::YOUTUBE()->getValue(), $dto->youtube);
        $list[] = $this->findOrCreate(SettingType::EMAIL()->getValue(), $dto->email);

        foreach ($list as $item) {
            $this->settingRepository->add($item);
        }

        $this->settingRepository->save();
    }

    public function getSettings(): array
    {
        return $this->settingRepository->findAll();
    }

    private function findOrCreate(string $name, string $value): Setting
    {
        $setting = $this->settingRepository->getByName($name);
        if ($setting) {
            return $setting->setValue($value);
        }
        if (SettingType::EMAIL === $name) {
            return new Setting($name, SettingType::EMAIL(), $value);
        }

        return new Setting($name, SettingType::SOCIAL_MEDIA(), $value);
    }
}
