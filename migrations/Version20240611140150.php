<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611140150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX IDX_6E6F5812BD29F359 ON audit_response (audit_id)');
        $this->addSql('CREATE INDEX IDX_6E6F58121E27F6BF ON audit_response (question_id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638597DF5D4 FOREIGN KEY (id_societe_id) REFERENCES societe (id)');
        $this->addSql('ALTER TABLE societe ADD CONSTRAINT FK_19653DBD79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX client_id ON audit (client_id)');
        $this->addSql('ALTER TABLE audit_response DROP FOREIGN KEY FK_6E6F5812BD29F359');
        $this->addSql('ALTER TABLE audit_response DROP FOREIGN KEY FK_6E6F58121E27F6BF');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638597DF5D4');
        $this->addSql('ALTER TABLE societe DROP FOREIGN KEY FK_19653DBD79F37AE5');
    }
}
