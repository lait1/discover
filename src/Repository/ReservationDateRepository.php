<?php

namespace App\Repository;

use App\Entity\OrderTour;
use App\Entity\ReservationDate;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservationDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationDate::class);
    }

    public function save(ReservationDate $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(ReservationDate $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function getOrdersOlderToday(): array
    {
        $date = new \DateTimeImmutable();

        return $this->createQueryBuilder('rd')
            ->where('rd.reservationDate > :bookTime')
            ->andWhere('rd.user IS NOT NULL')
            ->setParameter('bookTime', $date)
            ->getQuery()->getResult()
        ;
    }

    public function hasOrderSameDate(DateTimeInterface $date): bool
    {
        return (bool) $this->createQueryBuilder('rd')
            ->where('rd.reservationDate = :bookTime')
            ->andWhere('rd.user IS NOT NULL')
            ->setParameter('bookTime', $date)
            ->setMaxResults(1)
            ->getQuery()->getResult()
        ;
    }

    public function getOrderById(int $id): OrderTour
    {
        return $this->find($id);
    }

    public function getAllOrders(): array
    {
        return $this->findAll();
    }

    /**
     * @return ReservationDate[]
     */
    public function getByOrderId($order): array
    {
        return $this->findBy(['orderTour', $order]);
    }
}
