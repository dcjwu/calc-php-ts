<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219110206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calculations (id INT AUTO_INCREMENT NOT NULL, calculator_id INT NOT NULL, expression VARCHAR(255) NOT NULL, result DOUBLE PRECISION NOT NULL, INDEX IDX_4BFD195EACF2C4B8 (calculator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calculator (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calculations ADD CONSTRAINT FK_4BFD195EACF2C4B8 FOREIGN KEY (calculator_id) REFERENCES calculator (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calculations DROP FOREIGN KEY FK_4BFD195EACF2C4B8');
        $this->addSql('DROP TABLE calculations');
        $this->addSql('DROP TABLE calculator');
    }
}
