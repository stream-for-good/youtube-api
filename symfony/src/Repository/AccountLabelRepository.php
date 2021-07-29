<?php

namespace App\Repository;

use App\Entity\AccountLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AccountLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountLabel[]    findAll()
 * @method AccountLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountLabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountLabel::class);
    }

    // /**
    //  * @return AccountLabel[] Returns an array of AccountLabel objects
    //  */
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
    public function findOneBySomeField($value): ?AccountLabel
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
