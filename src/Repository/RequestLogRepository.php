<?php

namespace App\Repository;

use App\Entity\RequestLog;
use App\Model\RequestLogCriteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RequestLog>
 */
class RequestLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequestLog::class);
    }

    public function getNumberOfRecords(RequestLogCriteria $requestLogCriteria)
    {
        $qb = $this->createQueryBuilder('c')->select('COUNT(c)');

        if ($requestLogCriteria->getServiceNames()) {
            $qb->where($qb->expr()->in('c.serviceName', $requestLogCriteria->getServiceNames()));
        }

        if ($requestLogCriteria->getStatusCode()) {
            $qb->andWhere('c.statusCode = :statusCode')
                ->setParameter('statusCode', $requestLogCriteria->getStatusCode())
            ;
        }

        if ($requestLogCriteria->getStartDate()) {
            $qb->andWhere('c.date >= :startDate')
                ->setParameter('startDate', $requestLogCriteria->getStartDate())
            ;
        }

        if ($requestLogCriteria->getEndDate()) {
            $qb->andWhere('c.date <= :endDate')
                ->setParameter('endDate', $requestLogCriteria->getEndDate())
            ;
        }

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function truncate()
    {
        $entityManager = $this->getEntityManager();

        $tableName = $entityManager->getClassMetadata(RequestLog::class)->getTableName();

        $qb->executeQuery(sprintf('CREATE TABLE `new_%s` LIKE `%s`', $tableName, $tableName));
        $qb->executeQuery(sprintf('RENAME TABLE `%s` TO `old_%s`, `new_%s` TO `%s`', $tableName, $tableName, $tableName));
        $qb->executeQuery(sprintf('TRUNCATE TABLE `old_%s`', $tableName));
    }

//    /**
//     * @return RequestLog[] Returns an array of RequestLog objects
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

//    public function findOneBySomeField($value): ?RequestLog
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
