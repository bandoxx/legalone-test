<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class TruncateTable
{

    public function __construct(private EntityManagerInterface $entityManager)
    {}

    public function truncate(string $tableName)
    {
        $connection = $this->entityManager->getConnection();
        $schemaManager = $connection->createSchemaManager();
        $tables = $schemaManager->listTables();

        foreach ($tables as $table) {
            if ($table->getName() === $tableName) {
                $connection->executeQuery(sprintf('CREATE TABLE `new_%s` LIKE `%s`', $tableName, $tableName));
                $connection->executeQuery(sprintf('RENAME TABLE `%s` TO `old_%s`, `new_%s` TO `%s`', $tableName, $tableName, $tableName, $tableName));

                $schemaManager->dropTable(sprintf('old_%s', $tableName));

                return;
            }
        }
    }
}