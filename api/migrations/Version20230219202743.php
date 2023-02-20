<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219202743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calculator ADD token_id INT NOT NULL');
        $this->addSql('ALTER TABLE calculator ADD CONSTRAINT FK_247990C241DEE7B9 FOREIGN KEY (token_id) REFERENCES token (id)');
        $this->addSql('CREATE INDEX IDX_247990C241DEE7B9 ON calculator (token_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calculator DROP FOREIGN KEY FK_247990C241DEE7B9');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP INDEX IDX_247990C241DEE7B9 ON calculator');
        $this->addSql('ALTER TABLE calculator DROP token_id');
    }
}
