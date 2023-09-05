<?php
declare(strict_types=1);

namespace App\Domain;

use App\Entity\TourPhoto;
use App\Repository\TourPhotoRepository;
use App\Repository\TourRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService
{
    private FileUploader $fileUploader;

    private TourRepository $tourRepository;

    private TourPhotoRepository $photoRepository;

    public function __construct(
        FileUploader $fileUploader,
        TourPhotoRepository $photoRepository,
        TourRepository $tourRepository
    ) {
        $this->fileUploader = $fileUploader;
        $this->photoRepository = $photoRepository;
        $this->tourRepository = $tourRepository;
    }

    public function uploadMainPhoto(UploadedFile $photo, int $tourId): string
    {
        $path = $this->fileUploader->upload($photo);
        $tour = $this->tourRepository->getById($tourId);
        $tour->setMainImage($path);
        $this->tourRepository->save($tour);

        return $path;
    }

    public function uploadTourPhoto(array $photos, int $tourId): array
    {
        $protoList = [];
        $priority = 0;
        /** @var UploadedFile $photo */
        foreach ($photos as $photo) {
            $path = $this->fileUploader->upload($photo);
            $protoList[] = $this->saveTourPhoto($photo->getClientOriginalName(), $path, $tourId, ++$priority);
        }

        return $protoList;
    }

    public function removeTourPhoto(int $photoId): void
    {
        $photo = $this->photoRepository->getById($photoId);
        $this->photoRepository->remove($photo);
    }

    public function unsetMainPhoto(int $tourId): void
    {
        $tour = $this->tourRepository->getById($tourId);
        $tour->setMainImage(null);
        $this->tourRepository->save($tour);
    }

    private function saveTourPhoto(string $originalName, string $path, int $tourId, int $priority): TourPhoto
    {
        $tour = $this->tourRepository->getById($tourId);

        $photo = new TourPhoto($originalName, $path, $priority);
        $photo->setTour($tour);
        $this->photoRepository->save($photo);

        return $photo;
    }
}
