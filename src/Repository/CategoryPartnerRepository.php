<?php

namespace App\Repository;

use App\Entity\CategoryPartner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryPartner|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryPartner|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryPartner[]    findAll()
 * @method CategoryPartner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryPartnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryPartner::class);
    }

    // /**
    //  * @return CategoryPartner[] Returns an array of CategoryPartner objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryPartner
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
