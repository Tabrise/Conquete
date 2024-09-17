<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240913124011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_contrat (id INT AUTO_INCREMENT NOT NULL, id_contrat_id INT DEFAULT NULL, id_article_id INT DEFAULT NULL, qte INT NOT NULL, prix_tt DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_8DE6DD24BDA986C8 (id_contrat_id), UNIQUE INDEX UNIQ_8DE6DD24D71E064B (id_article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_contrat ADD CONSTRAINT FK_8DE6DD24BDA986C8 FOREIGN KEY (id_contrat_id) REFERENCES contrat (id)');
        $this->addSql('ALTER TABLE article_contrat ADD CONSTRAINT FK_8DE6DD24D71E064B FOREIGN KEY (id_article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE contrat_articles DROP FOREIGN KEY FK_6122B321823061F');
        $this->addSql('ALTER TABLE contrat_articles DROP FOREIGN KEY FK_6122B321EBAF6CC');
        $this->addSql('DROP TABLE contrat_articles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrat_articles (contrat_id INT NOT NULL, articles_id INT NOT NULL, INDEX IDX_6122B321EBAF6CC (articles_id), INDEX IDX_6122B321823061F (contrat_id), PRIMARY KEY(contrat_id, articles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE contrat_articles ADD CONSTRAINT FK_6122B321823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contrat_articles ADD CONSTRAINT FK_6122B321EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_contrat DROP FOREIGN KEY FK_8DE6DD24BDA986C8');
        $this->addSql('ALTER TABLE article_contrat DROP FOREIGN KEY FK_8DE6DD24D71E064B');
        $this->addSql('DROP TABLE article_contrat');
    }
}
