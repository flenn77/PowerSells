<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function countProductsOfLastMonth(): float|bool|int|string|null
    {
        $startDate = new \DateTime('first day of last month');
        $endDate = new \DateTime('last day of last month');

        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->andWhere('p.createdAt BETWEEN :start_date AND :end_date')
            ->setParameter('start_date', $startDate, \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE)
            ->setParameter('end_date', $endDate, \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findRecentProducts()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getAllProducts()
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();
    }
}
