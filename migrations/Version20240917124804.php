<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240917124804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_contrat DROP FOREIGN KEY FK_8DE6DD24D71E064B');
        $this->addSql('DROP INDEX UNIQ_8DE6DD24D71E064B ON article_contrat');
        $this->addSql('ALTER TABLE article_contrat CHANGE id_article_id id_offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article_contrat ADD CONSTRAINT FK_8DE6DD241C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offres (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8DE6DD241C13BCCF ON article_contrat (id_offre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_contrat DROP FOREIGN KEY FK_8DE6DD241C13BCCF');
        $this->addSql('DROP INDEX UNIQ_8DE6DD241C13BCCF ON article_contrat');
        $this->addSql('ALTER TABLE article_contrat CHANGE id_offre_id id_article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article_contrat ADD CONSTRAINT FK_8DE6DD24D71E064B FOREIGN KEY (id_article_id) REFERENCES articles (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8DE6DD24D71E064B ON article_contrat (id_article_id)');
    }
}
