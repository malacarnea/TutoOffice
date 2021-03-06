<?php

namespace App\Repository;

use App\Entity\Tutorials;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Tutorials|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tutorials|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tutorials[]    findAll()
 * @method Tutorials[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TutorialsRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Tutorials::class);
    }

    /**
     * 
     * @param int $idFormation
     * @return Tutorials[]
     */
    public function findOthersTutorialsByFormation(int $idFormation) {
        return $this->createQueryBuilder('t')
                        ->join("t.chapter", "c", null, null, "c.id")
                        ->join("c.formation", "f", null, null, "f.id")
                        ->andWhere('f.id = :id')
                        ->setParameter('id', $idFormation)
                        ->getQuery()
                        ->getResult()
        ;
    }

    // /**
    //  * @return Title[] Returns an array of Tutorials objects
    //  */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('t')
      ->andWhere('t.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('t.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?Tutorials
      {
      return $this->createQueryBuilder('t')
      ->andWhere('t.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
}
