<?php

namespace App\Repository;

use App\Entity\Discounts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Discounts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discounts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discounts[]    findAll()
 * @method Discounts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscountsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Discounts::class);
    }

//    /**
//     * @return Discounts[] Returns an array of Discounts objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Discounts
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
