<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221120209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calculations (id INT AUTO_INCREMENT NOT NULL, calculator_id INT NOT NULL, expression VARCHAR(255) NOT NULL, result VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4BFD195EACF2C4B8 (calculator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calculator (id INT AUTO_INCREMENT NOT NULL, token_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_247990C241DEE7B9 (token_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calculations ADD CONSTRAINT FK_4BFD195EACF2C4B8 FOREIGN KEY (calculator_id) REFERENCES calculator (id)');
        $this->addSql('ALTER TABLE calculator ADD CONSTRAINT FK_247990C241DEE7B9 FOREIGN KEY (token_id) REFERENCES token (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calculations DROP FOREIGN KEY FK_4BFD195EACF2C4B8');
        $this->addSql('ALTER TABLE calculator DROP FOREIGN KEY FK_247990C241DEE7B9');
        $this->addSql('DROP TABLE calculations');
        $this->addSql('DROP TABLE calculator');
        $this->addSql('DROP TABLE token');
    }
}
