<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250128174434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(20) NOT NULL, country VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, vin VARCHAR(255) NOT NULL, registration_number VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_rented TINYINT(1) NOT NULL, current_location VARCHAR(255) DEFAULT \'N/A\' NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, address_id INT NOT NULL, UNIQUE INDEX UNIQ_1B80E486B1085141 (vin), UNIQUE INDEX UNIQ_1B80E48638CEDFBE (registration_number), UNIQUE INDEX UNIQ_1B80E486F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486F5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE vehicle');
    }
}
