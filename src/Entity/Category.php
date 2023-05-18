<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Column(name="id", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @ORM\Column(name="name", type="string", length=255) */
    private string $name;

    /** @ORM\Column(name="priority", type="integer", options={"default": null, "unsigned": true}) */
    private ?int $priority;

    /** @ORM\ManyToMany(targetEntity=Tour::class, mappedBy="categories") */
    private $tours;

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
            $tour->addCategory($this);
        }

        return $this;
    }

    public function removeTour(Tour $tour): self
    {
        if ($this->tours->removeElement($tour)) {
            $tour->removeCategory($this);
        }

        return $this;
    }
}
