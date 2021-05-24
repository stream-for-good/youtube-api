<?php

namespace App\Repository;

use App\Entity\VideoLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoLabel[]    findAll()
 * @method VideoLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoLabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoLabel::class);
    }

    // /**
    //  * @return VideoLabel[] Returns an array of VideoLabel objects
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
    public function findOneBySomeField($value): ?VideoLabel
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
