<?php

namespace App\Repository;

use App\Entity\AuditResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuditResponse>
 *
 * @method AuditResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuditResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuditResponse[]    findAll()
 * @method AuditResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuditResponse::class);
    }
    public function findQuestionsByAuditId(int $auditId): array
    {
        return $this->createQueryBuilder('ar')
            ->innerJoin('ar.question', 'q')
            ->innerJoin('q.id_theme', 't')
            ->addSelect('q')
            ->addSelect('t')
            ->where('ar.audit = :auditId')
            ->andWhere('q.utiliser = 1')
            ->setParameter('auditId', $auditId)
            ->orderBy('q.ordre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return AuditResponse[] Returns an array of AuditResponse objects
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

    //    public function findOneBySomeField($value): ?AuditResponse
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
