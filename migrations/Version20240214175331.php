<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214175331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accommodation DROP FOREIGN KEY FK_2D385412B6CFDCA8');
        $this->addSql('DROP INDEX IDX_2D385412B6CFDCA8 ON accommodation');
        $this->addSql('ALTER TABLE accommodation ADD user_id INT DEFAULT NULL, DROP owner_id, CHANGE category_name_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE accommodation ADD CONSTRAINT FK_2D38541212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE accommodation ADD CONSTRAINT FK_2D385412A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2D38541212469DE2 ON accommodation (category_id)');
        $this->addSql('CREATE INDEX IDX_2D385412A76ED395 ON accommodation (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accommodation DROP FOREIGN KEY FK_2D38541212469DE2');
        $this->addSql('ALTER TABLE accommodation DROP FOREIGN KEY FK_2D385412A76ED395');
        $this->addSql('DROP INDEX IDX_2D38541212469DE2 ON accommodation');
        $this->addSql('DROP INDEX IDX_2D385412A76ED395 ON accommodation');
        $this->addSql('ALTER TABLE accommodation ADD category_name_id INT DEFAULT NULL, ADD owner_id INT NOT NULL, DROP category_id, DROP user_id');
        $this->addSql('ALTER TABLE accommodation ADD CONSTRAINT FK_2D385412B6CFDCA8 FOREIGN KEY (category_name_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_2D385412B6CFDCA8 ON accommodation (category_name_id)');
    }
}
