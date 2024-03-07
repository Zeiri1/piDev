<?php

namespace App\Repository;

use App\Entity\Referance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Referance>
 *
 * @method Referance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Referance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Referance[]    findAll()
 * @method Referance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Referance::class);
    }

//    /**
//     * @return Referance[] Returns an array of Referance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Referance
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
