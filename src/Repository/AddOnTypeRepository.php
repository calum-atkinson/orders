<?php

namespace App\Repository;

use App\Entity\AddOnType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AddOnType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AddOnType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AddOnType[]    findAll()
 * @method AddOnType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddOnTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddOnType::class);
    }

    // /**
    //  * @return AddOnType[] Returns an array of AddOnType objects
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
    public function findOneBySomeField($value): ?AddOnType
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
