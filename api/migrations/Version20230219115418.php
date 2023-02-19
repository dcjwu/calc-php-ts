<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219115418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calculator ADD session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calculator ADD CONSTRAINT FK_247990C2613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_247990C2613FECDF ON calculator (session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calculator DROP FOREIGN KEY FK_247990C2613FECDF');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP INDEX IDX_247990C2613FECDF ON calculator');
        $this->addSql('ALTER TABLE calculator DROP session_id');
    }
}
