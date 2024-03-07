<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219182034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB19EB6921');
        $this->addSql('DROP TABLE vol');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vol (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, date_depart DATE DEFAULT NULL, date_arrivee DATE DEFAULT NULL, INDEX IDX_95C97EB19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }
}
