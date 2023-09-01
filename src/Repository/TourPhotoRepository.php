<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\TourPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class TourPhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TourPhoto::class);
    }

    public function save(TourPhoto $photo): void
    {
        $this->getEntityManager()->persist($photo);
        $this->getEntityManager()->flush();
    }

    public function remove(TourPhoto $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function getById(int $id): TourPhoto
    {
        $photo = $this->findOneBy(['id' => $id]);
        if ($photo === null) {
            throw new NotFoundResourceException("Photo not found {$id}");
        }

        return $photo;
    }
}
