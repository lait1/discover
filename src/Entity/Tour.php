<?php
declare(strict_types=1);

namespace App\Entity;

use App\Enum\PriceDetailsTypeEnum;
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
    public const UNIQ_TOUR = 'uniq';

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
    private ?string $mainImage;

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

    /** @ORM\Column(type="string", nullable=true) */
    private ?string $youtubeLink;

    /** @ORM\Column(name="created_at", type="integer", nullable=false, options={"unsigned": true}) */
    private int $createdAt;

    /** @ORM\Column(type="boolean") */
    private bool $public;

    /** @ORM\ManyToMany(targetEntity=Category::class, inversedBy="tours") */
    private PersistentCollection $categories;

    /** @ORM\OneToMany(targetEntity=TourPhoto::class, mappedBy="tour", cascade={"persist", "remove"}) */
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

    public function getAssessment(): string
    {
        if ($this->reviews->isEmpty()) {
            return '5.0';
        }

        $reviewAssessment = array_map(function (Review $review) {
            return $review->getAssessment();
        }, ($this->reviews->toArray()));
        $average = array_sum($reviewAssessment) / count($reviewAssessment);

        return number_format($average, 1, '.', '');
    }

    public function getPhotosPaths(): ?string
    {
        if ($this->photos->isEmpty()) {
            return null;
        }

        $photos = $this->photos->toArray();
        usort($photos, fn (TourPhoto $a, TourPhoto $b) => $a->getPriority() <=> $b->getPriority());
        $paths = array_map(function (TourPhoto $photo) {
            return $photo->getPath();
        }, $photos);

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

    public function getMainImage(): ?string
    {
        return $this->mainImage ?? '';
    }

    public function setMainImage(?string $mainImage): void
    {
        $this->mainImage = "/uploads/{$mainImage}";
    }

    public function setName(string $name): void
    {
        $slugger = new AsciiSlugger('ru');
        $this->name = $name;
        $this->slug = $slugger->slug($name);
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function setLongTime(?string $longTime): void
    {
        $this->longTime = $longTime;
    }

    public function setComplexity(?string $complexity): void
    {
        $this->complexity = $complexity;
    }

    public function setGroupSize(?int $groupSize): void
    {
        $this->groupSize = $groupSize;
    }

    public function setDetails(?array $details): void
    {
        $this->details = $details;
    }

    public function setKeyWords(?string $keyWords): void
    {
        $this->keyWords = $keyWords;
    }

    public function setPublic(bool $public): void
    {
        $this->public = $public;
    }

    public function setCategories(array $categories): void
    {
        $this->categories->clear();

        foreach ($categories as $category) {
            $this->categories->add($category);
        }
    }

    public function setPhotos(PersistentCollection $photos): void
    {
        $this->photos = $photos;
    }

    public function setReviews(PersistentCollection $reviews): void
    {
        $this->reviews = $reviews;
    }

    public function setTourDescriptions(PersistentCollection $tourDescriptions): void
    {
        $this->tourDescriptions = $tourDescriptions;
    }

    public function getYoutubeLink(): ?string
    {
        return $this->youtubeLink;
    }

    public function setYoutubeLink(?string $youtubeLink): void
    {
        $this->youtubeLink = $youtubeLink;
    }

    public function setIncludePriceDetails(array $includePrice): void
    {
        $this->details[PriceDetailsTypeEnum::INCLUDE] = $includePrice;
    }

    public function setExcludePriceDetails(array $excludePrice): void
    {
        $this->details[PriceDetailsTypeEnum::EXCLUDE] = $excludePrice;
    }

    public function getIncludePriceDetails(): array
    {
        return $this->details[PriceDetailsTypeEnum::INCLUDE] ?? [];
    }

    public function getExcludePriceDetails(): array
    {
        return $this->details[PriceDetailsTypeEnum::EXCLUDE] ?? [];
    }
}
