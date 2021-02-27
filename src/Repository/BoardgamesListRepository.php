<?php

namespace App\Repository;

use App\Entity\BoardgamesList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BoardgamesList|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardgamesList|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardgamesList[]    findAll()
 * @method BoardgamesList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardgamesListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardgamesList::class);
    }

    // /**
    //  * @return BoardgamesList[] Returns an array of BoardgamesList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BoardgamesList
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
