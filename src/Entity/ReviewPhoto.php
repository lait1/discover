<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ReviewPhotoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReviewPhotoRepository::class)
 */
class ReviewPhoto implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /** @ORM\Column(type="string", length=255) */
    private string $path;

    /** @ORM\ManyToOne(targetEntity=Review::class, inversedBy="reviewPhotos",  cascade={"persist", "remove"}) */
    private $reviews;

    public function __construct(string $path)
    {
        $this->path = "/uploads/{$path}";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getReviews(): ?Review
    {
        return $this->reviews;
    }

    public function setReviews(?Review $reviews): self
    {
        $this->reviews = $reviews;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'   => $this->id,
            'path' => $this->path,
        ];
    }
}
