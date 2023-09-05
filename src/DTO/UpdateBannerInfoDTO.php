<?php
declare(strict_types=1);

namespace App\DTO;

class UpdateBannerInfoDTO
{
    public int $id;

    public string $name;

    public string $title;

    public array $categories;
}
