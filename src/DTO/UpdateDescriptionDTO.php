<?php
declare(strict_types=1);

namespace App\DTO;

class UpdateDescriptionDTO
{
    public int $id;

    public int $tourId;

    public string $header;

    public string $content;

    public function __construct(array $data)
    {
        $this->id = (int) $data['id'];
        $this->tourId = (int) $data['tourId'];
        $this->header = $data['header'];
        $this->content = $data['content'];
    }
}
