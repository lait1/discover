<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tour_descriptions")
 * @ORM\Entity(repositoryClass="App\Repository\TourPhotoRepository")
 */
class TourDescription
{
    /**
     * @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @ORM\Column(type="string") */
    private string $header;

    /** @ORM\Column(type="text") */
    private string $content;

    /** @ORM\Column(type="string") */
    private string $image;

    /** @ORM\ManyToOne(targetEntity=Tour::class, inversedBy="tourDescriptions") */
    private $tour;

    public function getTour(): ?Tour
    {
        return $this->tour;
    }

    public function setTour(?Tour $tour): self
    {
        $this->tour = $tour;

        return $this;
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
