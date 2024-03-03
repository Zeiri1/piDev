<?php

namespace App\Repository;

use App\Entity\Accommodation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Accommodation>
 *
 * @method Accommodation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accommodation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accommodation[]    findAll()
 * @method Accommodation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccommodationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accommodation::class);
    }

   /**
    * @return Accommodation[] Returns an array of Accommodation objects
    */
   public function searchByTitle($value): array
   {
    return $this->createQueryBuilder('a')
        ->where('a.Title LIKE :name' )
        ->setParameter('name' , '%'.$value.'%') 
        ->getQuery()  
    ->getResult() ;
   }

   public function searchByMinMax($min,$max){
    $em= $this->getEntityManager();
    return $em->createQuery('SELECT a from App\Entity\Accommodation a where a.Price BETWEEN :min and :max ' )

    ->setParameters(['min'=>$min ,'max'=>$max]) 
    ->getResult() ;
}

public function searchByTitleAndMinMax($title, $min,$max){
    $em= $this->getEntityManager();
    return $em->createQuery('SELECT a from App\Entity\Accommodation a where a.Title LIKE :title and a.Price BETWEEN :min and :max ' )

    ->setParameters(['title'=>'%'.$title.'%','min'=>$min ,'max'=>$max]) 
    ->getResult() ;
}

//    public function findOneBySomeField($value): ?Accommodation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
