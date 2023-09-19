<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tour_descriptions")
 * @ORM\Entity(repositoryClass="App\Repository\TourDescriptionRepository")
 */
class TourDescription implements \JsonSerializable
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

    public function __construct(string $header, string $content, string $image)
    {
        $this->header = $header;
        $this->content = $content;
        $this->image = "/uploads/{$image}";
    }

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

    public function setHeader(string $header): void
    {
        $this->header = $header;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'      => $this->id,
            'header'  => $this->header,
            'content' => $this->content,
            'image'   => $this->image,
        ];
    }
}
