<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723121801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE societe ADD etat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE societe ADD CONSTRAINT FK_19653DBDD5E86FF FOREIGN KEY (etat_id) REFERENCES etat_societe (id)');
        $this->addSql('CREATE INDEX IDX_19653DBDD5E86FF ON societe (etat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE societe DROP FOREIGN KEY FK_19653DBDD5E86FF');
        $this->addSql('DROP INDEX IDX_19653DBDD5E86FF ON societe');
        $this->addSql('ALTER TABLE societe DROP etat_id');
    }
}
