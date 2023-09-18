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

    public function getEmailMedia(): string
    {
        $email = $this->settingRepository->getByName(SettingType::EMAIL()->getValue());
        if ($email) {
            return $email->getValue();
        }

        return 'georgia.dicover@gmail.com';
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

    public function getGalleryMainPage(): string
    {
        $imageList = [
            'build/images/gallery/photo_2_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_4_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_1_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_3_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_5_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_6_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_7_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_8_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_9_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_10_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_11_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_12_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_13_2023-09-18_21-19-10.jpg',
            'build/images/gallery/photo_14_2023-09-18_21-19-10.jpg',
        ];

        return json_encode($imageList);
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
