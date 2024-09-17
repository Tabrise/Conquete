<?php

namespace App\Repository;

use App\Entity\ArticleContrat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticleContrat>
 *
 * @method ArticleContrat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleContrat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleContrat[]    findAll()
 * @method ArticleContrat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleContratRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleContrat::class);
    }

//    /**
//     * @return ArticleContrat[] Returns an array of ArticleContrat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ArticleContrat
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
