<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    public function __construct()
    {
        $this->tours = new ArrayCollection();
    }

    /**
     * @return Collection<int, Tour>
     */
    public function getTours(): Collection
    {
        return $this->tours;
    }

    public function addTour(Tour $tour): self
    {
        if (!$this->tours->contains($tour)) {
            $this->tours[] = $tour;
            $tour->addPhoto($this);
        }

        return $this;
    }

    public function removeTour(Tour $tour): self
    {
        if ($this->tours->removeElement($tour)) {
            $tour->removePhoto($this);
        }

        return $this;
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
}
