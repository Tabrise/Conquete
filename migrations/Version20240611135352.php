<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611135352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit ADD CONSTRAINT FK_9218FF7919EB6921 FOREIGN KEY (client_id) REFERENCES societe (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9218FF7919EB6921 ON audit (client_id)');
        $this->addSql('ALTER TABLE audit_response ADD question_id INT DEFAULT NULL, ADD response VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE audit_response ADD CONSTRAINT FK_6E6F58121E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_6E6F58121E27F6BF ON audit_response (question_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit DROP FOREIGN KEY FK_9218FF7919EB6921');
        $this->addSql('DROP INDEX UNIQ_9218FF7919EB6921 ON audit');
        $this->addSql('ALTER TABLE audit_response DROP FOREIGN KEY FK_6E6F58121E27F6BF');
        $this->addSql('DROP INDEX IDX_6E6F58121E27F6BF ON audit_response');
        $this->addSql('ALTER TABLE audit_response DROP question_id, DROP response');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638597DF5D4');
        $this->addSql('ALTER TABLE societe DROP FOREIGN KEY FK_19653DBD79F37AE5');
    }
}
