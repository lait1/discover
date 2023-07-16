<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Tour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * @method Tour|null findOneBy(array $criteria, array $orderBy = null)
 */
class TourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tour::class);
    }

    public function save(Tour $tour): void
    {
        $this->getEntityManager()->persist($tour);
        $this->getEntityManager()->flush();
    }

    public function getTourBySlug(string $slug): Tour
    {
        $tour = $this->findOneBy(['slug' => $slug]);
        if ($tour === null) {
            throw new NotFoundResourceException("Tour not found by {$slug}");
        }

        return $tour;
    }

    public function getById(int $id): Tour
    {
        $tour = $this->findOneBy(['id' => $id]);
        if ($tour === null) {
            throw new NotFoundResourceException("Tour not found {$id}");
        }

        return $tour;
    }
}
