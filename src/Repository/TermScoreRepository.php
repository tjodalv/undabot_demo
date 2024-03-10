<?php

namespace App\Repository;

use App\Entity\TermScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TermScore>
 *
 * @method TermScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method TermScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method TermScore[]    findAll()
 * @method TermScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TermScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TermScore::class);
    }

    //    /**
    //     * @return TermScore[] Returns an array of TermScore objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TermScore
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
