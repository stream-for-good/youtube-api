<?php

namespace App\Repository;

use App\Entity\Video;
use App\Entity\Caption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */

    public function findByAllVideosInArray($array)
    {
        return $this->createQueryBuilder('v')
            ->where('v.id IN (:val)')
            ->setParameter('val', $array)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByStatus()
    {
        return $this->createQueryBuilder('v')
            ->where('v.status = true')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCaption(string $id)
    {
        return $this->createQueryBuilder('s')
            ->from(Caption::class, 'u')
            ->andWhere('u.video !=' .$id)
            ->andWhere('s.id =' .$id)
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Video
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
