<?php
declare(strict_types=1);

namespace App\View;

use App\Entity\Tour;

class TourView implements \JsonSerializable
{
    private Tour $tour;

    private ?array $inPrice;

    private ?array $exPrice;

    public function __construct(Tour $tour, ?array $inPrice = null, ?array $exPrice = null)
    {
        $this->tour = $tour;
        $this->inPrice = $inPrice;
        $this->exPrice = $exPrice;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'               => $this->tour->getId(),
            'name'             => $this->tour->getName(),
            'slug'             => $this->tour->getSlug(),
            'title'            => $this->tour->getTitle(),
            'description'      => $this->tour->getDescription(),
            'price'            => $this->tour->getPrice(),
            'longTime'         => $this->tour->getLongTime(),
            'complexity'       => $this->tour->getComplexity(),
            'groupSize'        => $this->tour->getGroupSize(),
            'keyWords'         => $this->tour->getKeyWords(),
            'createdAt'        => $this->tour->getCreatedAt(),
            'public'           => $this->tour->isPublic(),
            'categories'       => $this->tour->getCategories(),
            'photos'           => $this->tour->getPhotos(),
            'tourDescriptions' => $this->tour->getTourDescriptions(),
            'mainPhoto'        => $this->tour->getMainImage(),
            'youtubeLink'      => $this->tour->getYoutubeLink(),
            'includePrice'     => $this->inPrice,
            'excludePrice'     => $this->exPrice,
        ];
    }
}
