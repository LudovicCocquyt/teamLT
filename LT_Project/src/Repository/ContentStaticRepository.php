<?php

namespace App\Repository;

use App\Entity\ContentStatic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContentStatic|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentStatic|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentStatic[]    findAll()
 * @method ContentStatic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentStaticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContentStatic::class);
    }

    // /**
    //  * @return ContentStatic[] Returns an array of ContentStatic objects
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
    public function findOneBySomeField($value): ?ContentStatic
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
