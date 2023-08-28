<?php

namespace App\Repository;

use App\Entity\OrderTour;
use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 *
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderTourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderTour::class);
    }

    public function save(OrderTour $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(OrderTour $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getOrdersOlderToday(): array
    {
        return $this->createQueryBuilder('ord')
            ->where('ord.reservationDate > :bookTime')
            ->setParameter('bookTime', time())
            ->getQuery()->getResult()
        ;
    }

    public function hasOrderSameDate(int $timestamp): bool
    {
        return (bool) $this->createQueryBuilder('ord')
            ->where('ord.reservationDate = :bookTime')
            ->setParameter('bookTime', $timestamp)
            ->setMaxResults(1)
            ->getQuery()->getOneOrNullResult()
        ;
    }
}
