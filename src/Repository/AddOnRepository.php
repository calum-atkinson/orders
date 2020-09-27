<?php

namespace App\Repository;

use App\Entity\AddOn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AddOn|null find($id, $lockMode = null, $lockVersion = null)
 * @method AddOn|null findOneBy(array $criteria, array $orderBy = null)
 * @method AddOn[]    findAll()
 * @method AddOn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddOnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddOn::class);
    }

    // /**
    //  * @return AddOn[] Returns an array of AddOn objects
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
    public function findOneBySomeField($value): ?AddOn
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
