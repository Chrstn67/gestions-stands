<?php

namespace App\Repository;

use App\Entity\Stands;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stands>
 *
 * @method Stands|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stands|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stands[]    findAll()
 * @method Stands[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stands::class);
    }

//    /**
//     * @return Stands[] Returns an array of Stands objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Stands
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
