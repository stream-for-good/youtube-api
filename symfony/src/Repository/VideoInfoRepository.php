<?php

namespace App\Repository;

use App\Entity\VideoInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoInfo[]    findAll()
 * @method VideoInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoInfo::class);
    }

    // /**
    //  * @return VideoInfo[] Returns an array of VideoInfo objects
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
    public function findOneBySomeField($value): ?VideoInfo
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
