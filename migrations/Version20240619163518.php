<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619163518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE log_tracker (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, last_processed_offset VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_log (id BIGINT AUTO_INCREMENT NOT NULL, service_name VARCHAR(255) NOT NULL, date DATETIME NOT NULL, status_code INT NOT NULL, INDEX idx_status_code_date (status_code, date), INDEX idx_status_code_service_name (service_name, status_code), INDEX idx_service_name_date (service_name, date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("INSERT INTO `log_tracker` (`id`, `path`, `last_processed_offset`) VALUES (NULL, '/var/www/html/src/Command/../../test-data/logs.log', '0')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE log_tracker');
        $this->addSql('DROP TABLE request_log');
    }
}
