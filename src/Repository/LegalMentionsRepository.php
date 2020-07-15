<?php

namespace App\Repository;

use App\Entity\LegalMentions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LegalMentions|null find($id, $lockMode = null, $lockVersion = null)
 * @method LegalMentions|null findOneBy(array $criteria, array $orderBy = null)
 * @method LegalMentions[]    findAll()
 * @method LegalMentions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegalMentionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalMentions::class);
    }

    // /**
    //  * @return LegalMentions[] Returns an array of LegalMentions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LegalMentions
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
