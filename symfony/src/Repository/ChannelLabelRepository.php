<?php

namespace App\Repository;

use App\Entity\ChannelLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChannelLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChannelLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChannelLabel[]    findAll()
 * @method ChannelLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChannelLabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChannelLabel::class);
    }

    // /**
    //  * @return ChannelLabel[] Returns an array of ChannelLabel objects
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
    public function findOneBySomeField($value): ?ChannelLabel
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
