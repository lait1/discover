<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\TourDescription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TourDescriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TourDescription::class);
    }

    public function save(TourDescription $description)
    {
        $this->getEntityManager()->persist($description);
        $this->getEntityManager()->flush();
    }
}
