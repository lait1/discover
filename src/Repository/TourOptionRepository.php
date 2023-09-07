<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\TourOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TourOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TourOption::class);
    }

    public function save(TourOption $tourOption)
    {
        $this->getEntityManager()->persist($tourOption);
        $this->getEntityManager()->flush();
    }
}
