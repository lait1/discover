<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tour_photos")
 * @ORM\Entity(repositoryClass="App\Repository\TourPhotoRepository")
 */
class TourPhoto implements \JsonSerializable
{
    /**
     * @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @ORM\Column(type="string") */
    private string $path;

    /** @ORM\Column(type="string") */
    private string $originalName;

    /** @ORM\Column(type="integer") */
    private int $priority;

    /** @ORM\ManyToOne(targetEntity=Tour::class, inversedBy="photos") */
    private $tour;

    public function __construct(string $name, string $path, int $priority)
    {
        $this->originalName = $name;
        $this->path = "/uploads/{$path}";
        $this->priority = $priority;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setTour(Tour $tour): void
    {
        $this->tour = $tour;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'       => $this->id,
            'path'     => $this->path,
            'name'     => $this->originalName,
            'priority' => $this->priority,
        ];
    }
}
