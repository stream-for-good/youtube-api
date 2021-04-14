<?php

namespace App\Repository;

use App\Entity\ChannelCategoryLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChannelCategoryLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChannelCategoryLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChannelCategoryLabel[]    findAll()
 * @method ChannelCategoryLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChannelCategoryLabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChannelCategoryLabel::class);
    }

    // /**
    //  * @return ChannelCategoryLabel[] Returns an array of ChannelCategoryLabel objects
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
    public function findOneBySomeField($value): ?ChannelCategoryLabel
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
