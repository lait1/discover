<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tour_photos")
 * @ORM\Entity(repositoryClass="App\Repository\TourPhotoRepository")
 */
class TourPhoto
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
    private string $name;

    /** @ORM\Column(type="boolean") */
    private bool $main;

    /** @ORM\ManyToOne(targetEntity=Tour::class, inversedBy="photos") */
    private $tour;

    public function __construct(string $path, string $name, bool $main = false)
    {
        $this->path = $path;
        $this->name = $name;
        $this->main = $main;
    }
}
