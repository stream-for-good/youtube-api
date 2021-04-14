<?php

namespace App\Repository;

use App\Entity\ChannelCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChannelCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChannelCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChannelCategory[]    findAll()
 * @method ChannelCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChannelCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChannelCategory::class);
    }

    // /**
    //  * @return ChannelCategory[] Returns an array of ChannelCategory objects
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
    public function findOneBySomeField($value): ?ChannelCategory
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
