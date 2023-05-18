<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Tour;
use Doctrine\ORM\EntityRepository;

/**
 * @method Tour|null findOneBy(array $criteria, array $orderBy = null)
 */
class TourRepository extends EntityRepository
{
    public function save(Tour $tour): void
    {
        $this->getEntityManager()->persist($tour);
        $this->getEntityManager()->flush();
    }
}
