<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\String\Slugger\AsciiSlugger;

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
    private string $slug;

    /** @ORM\Column(type="string", nullable=true) */
    private ?string $title;

    /** @ORM\Column(type="text", nullable=true) */
    private ?string $description;

    /** @ORM\Column(type="string", nullable=true) */
    private string $mainImage;

    /** @ORM\Column(type="integer", nullable=true, options={"unsigned": true, "default": 0}) */
    private int $price = 0;

    /** @ORM\Column(type="string", nullable=true) */
    private ?string $longTime;

    /** @ORM\Column(type="string", nullable=true) */
    private ?string $complexity;

    /** @ORM\Column(name="group_size", type="integer", nullable=true, options={"unsigned": true}) */
    private ?int $groupSize;

    /** @ORM\Column(name="details", type="json", nullable=true) */
    private ?array $details;

    /** @ORM\Column(type="string", nullable=true) */
    private ?string $keyWords;

    /** @ORM\Column(name="created_at", type="integer", nullable=false, options={"unsigned": true}) */
    private int $createdAt;

    /** @ORM\Column(type="boolean") */
    private bool $public;

    /** @ORM\ManyToMany(targetEntity=Category::class, inversedBy="tours") */
    private PersistentCollection $categories;

    /** @ORM\OneToMany(targetEntity=TourPhoto::class, mappedBy="tour") */
    private PersistentCollection $photos;

    /** @ORM\OneToMany(targetEntity=Review::class, mappedBy="tour") */
    private PersistentCollection $reviews;

    /** @ORM\OneToMany(targetEntity=TourDescription::class, mappedBy="tour") */
    private PersistentCollection $tourDescriptions;

    public function __construct(
        string $name
    ) {
        $slugger = new AsciiSlugger('ru');
        $this->name = $name;
        $this->slug = $slugger->slug($name);
        $this->createdAt = time();
        $this->public = false;
    }

    /**
     * @return Collection<int, TourPhoto>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function getPhotosPaths(): string
    {
        $paths = array_map(function (TourPhoto $photo) {
            return $photo->getPath();
        }, $this->photos->toArray());

        return json_encode($paths);
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

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setTour($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getTour() === $this) {
                $review->setTour(null);
            }
        }

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|\Symfony\Component\String\AbstractUnicodeString
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getAdaptiveDescription(): string
    {
        $description = $this->description;

        if ($description !== null && strlen($description) > 350) {
            $string = substr($description, 0, 350);
            $formattedText = substr($string, 0, strrpos($string, ' '));

            return $formattedText . '...';
        }

        return $description ?? 'Нет описания';
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getLongTime(): ?string
    {
        return $this->longTime;
    }

    public function getComplexity(): ?string
    {
        return $this->complexity;
    }

    public function getGroupSize(): ?int
    {
        return $this->groupSize;
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }

    public function getKeyWords(): string
    {
        return $this->keyWords ?? 'туризм, грузия, веселье, вино, горы';
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * @return Collection<int, TourDescription>
     */
    public function getTourDescriptions(): Collection
    {
        return $this->tourDescriptions;
    }

    public function addTourDescription(TourDescription $tourDescription): self
    {
        if (!$this->tourDescriptions->contains($tourDescription)) {
            $this->tourDescriptions[] = $tourDescription;
            $tourDescription->setTour($this);
        }

        return $this;
    }

    public function removeTourDescription(TourDescription $tourDescription): self
    {
        if ($this->tourDescriptions->removeElement($tourDescription)) {
            // set the owning side to null (unless already changed)
            if ($tourDescription->getTour() === $this) {
                $tourDescription->setTour(null);
            }
        }

        return $this;
    }

    public function getMainImage(): string
    {
        return "build/images/{$this->mainImage}";
    }

    public function setMainImage(string $mainImage): void
    {
        $this->mainImage = $mainImage;
    }
}
