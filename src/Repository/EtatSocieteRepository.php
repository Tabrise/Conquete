<?php

namespace App\Repository;

use App\Entity\EtatSociete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtatSociete>
 *
 * @method EtatSociete|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatSociete|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatSociete[]    findAll()
 * @method EtatSociete[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatSocieteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatSociete::class);
    }

//    /**
//     * @return EtatSociete[] Returns an array of EtatSociete objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EtatSociete
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
