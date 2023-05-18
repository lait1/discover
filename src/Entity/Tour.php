<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tours")
 * @ORM\Entity(repositoryClass="App\Repository\TourRepository")
 */
class Tour
{
    /**
     * @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /** @ORM\Column(type="string") */
    private string $name;

    /** @ORM\Column(type="string") */
    private string $title;

    /** @ORM\Column(type="integer", nullable=false, options={"unsigned": true}) */
    private string $price;

    /** @ORM\Column(type="string") */
    private string $duration;

    /** @ORM\Column(type="string") */
    private string $complexity;

    /** @ORM\Column(name="band_size", type="integer", nullable=false, options={"unsigned": true}) */
    private int $bandSize;

    /** @ORM\Column(name="content", type="json") */
    private array $content;

    /** @ORM\Column(name="details", type="json") */
    private array $details;

    /** @ORM\Column(name="created_at", type="integer", nullable=false, options={"unsigned": true}) */
    private int $createdAt;

    /** @ORM\ManyToMany(targetEntity=Category::class, inversedBy="tours") */
    private ArrayCollection $categories;

    /** @ORM\OneToMany(targetEntity=TourPhoto::class, mappedBy="tour") */
    private ArrayCollection $photos;

    /** @ORM\Column(type="boolean") */
    private bool $public;

    public function __construct(
        string $title,
        string $price,
        string $duration,
        string $complexity,
        int $bandSize,
        array $content,
        array $details
    ) {
        $this->title = $title;
        $this->price = $price;
        $this->duration = $duration;
        $this->complexity = $complexity;
        $this->bandSize = $bandSize;
        $this->content = $content;
        $this->details = $details;
        $this->createdAt = time();
        $this->photos = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    /**
     * @return Collection<int, TourPhoto>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(TourPhoto $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
        }

        return $this;
    }

    public function removePhoto(TourPhoto $photo): self
    {
        $this->photos->removeElement($photo);

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
