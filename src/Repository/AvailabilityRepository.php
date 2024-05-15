<?php

namespace App\Repository;

use App\Entity\Availability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Availability>
 *
 * @method Availability|null find($id, $lockMode = null, $lockVersion = null)
 * @method Availability|null findOneBy(array $criteria, array $orderBy = null)
 * @method Availability[]    findAll()
 * @method Availability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Availability::class);
    }

    /**
     * Find availabilities within a date range.
     *
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     * @return Availability[]
     */
    public function findByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
{
    return $this->createQueryBuilder('a')
        ->andWhere('a.StartDate >= :startDate')
        ->andWhere('a.endDate <= :endDate')
        ->setParameter('startDate', $startDate)
        ->setParameter('endDate', $endDate)
        ->getQuery()
        ->getResult();
}

/**
 * Find availabilities within a date range and maximum price.
 *
 * @param \DateTimeInterface $startDate
 * @param \DateTimeInterface $endDate
 * @param float|null $maxPrice
 * @return Availability[]
 */
public function findByDateAndMaxPrice(
    \DateTimeInterface $startDate,
    \DateTimeInterface $endDate,
    ?float $maxPrice = null
): array {
    $queryBuilder = $this->createQueryBuilder('a')
        ->andWhere('a.StartDate >= :startDate')
        ->andWhere('a.endDate <= :endDate')
        ->setParameter('startDate', $startDate)
        ->setParameter('endDate', $endDate);

    if ($maxPrice !== null) {
        $queryBuilder
            ->andWhere('a.Price <= :maxPrice')
            ->setParameter('maxPrice', $maxPrice);
    }

    return $queryBuilder
        ->getQuery()
        ->getResult();
}
}
