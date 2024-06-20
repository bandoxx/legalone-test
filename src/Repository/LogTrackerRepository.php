<?php

namespace App\Repository;

use App\Entity\LogTracker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogTracker>
 */
class LogTrackerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogTracker::class);
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
    //     * @return LogTracker[] Returns an array of LogTracker objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?LogTracker
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
