<?php

namespace App\Repository;

use App\Entity\OrderTour;
use App\Entity\Review;
use App\Enum\OrderStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 *
 * @method OrderTour|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderTour|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderTour[]    findAll()
 * @method OrderTour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
            ->andWhere('ord.status = :status')
            ->setParameter('bookTime', time())
            ->setParameter('status', OrderStatusEnum::APPROVE())
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

    public function getOrderById(int $id): OrderTour
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function getAllOrders(): array
    {
        return $this->createQueryBuilder('prd')
            ->orderBy('prd.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
