<?php

namespace App\Repository;

use App\Entity\AgesPrices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AgesPrices|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgesPrices|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgesPrices[]    findAll()
 * @method AgesPrices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgesPricesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AgesPrices::class);
    }

//    /**
//     * @return AgesPrices[] Returns an array of AgesPrices objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AgesPrices
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
