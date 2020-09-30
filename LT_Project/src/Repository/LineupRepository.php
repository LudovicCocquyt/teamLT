<?php

namespace App\Repository;

use App\Entity\Lineup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lineup|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lineup|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lineup[]    findAll()
 * @method Lineup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lineup::class);
    }

    // /**
    //  * @return Lineup[] Returns an array of Lineup objects
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
    public function findOneBySomeField($value): ?Lineup
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
