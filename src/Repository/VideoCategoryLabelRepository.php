<?php

namespace App\Repository;

use App\Entity\VideoCategoryLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoCategoryLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoCategoryLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoCategoryLabel[]    findAll()
 * @method VideoCategoryLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoCategoryLabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoCategoryLabel::class);
    }

    // /**
    //  * @return VideoCategoryLabel[] Returns an array of VideoCategoryLabel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VideoCategoryLabel
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
