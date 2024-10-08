<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240911131004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat_prestation DROP FOREIGN KEY FK_ECFE7AC69E45C554');
        $this->addSql('ALTER TABLE contrat_prestation DROP FOREIGN KEY FK_ECFE7AC61823061F');
        $this->addSql('ALTER TABLE options DROP FOREIGN KEY FK_D035FA871C13BCCF');
        $this->addSql('ALTER TABLE prestation_offre DROP FOREIGN KEY FK_6D0DCDEE9E45C554');
        $this->addSql('ALTER TABLE prestation_offre DROP FOREIGN KEY FK_6D0DCDEE4CC8505A');
        $this->addSql('DROP TABLE contrat_prestation');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE options');
        $this->addSql('DROP TABLE prestation');
        $this->addSql('DROP TABLE prestation_offre');
        $this->addSql('ALTER TABLE contrat ADD id_societe_id INT DEFAULT NULL, ADD date_crea DATETIME NOT NULL, DROP nom, DROP description');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993597DF5D4 FOREIGN KEY (id_societe_id) REFERENCES societe (id)');
        $this->addSql('CREATE INDEX IDX_60349993597DF5D4 ON contrat (id_societe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrat_prestation (contrat_id INT NOT NULL, prestation_id INT NOT NULL, INDEX IDX_ECFE7AC61823061F (contrat_id), INDEX IDX_ECFE7AC69E45C554 (prestation_id), PRIMARY KEY(contrat_id, prestation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix_mensuelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE options (id INT AUTO_INCREMENT NOT NULL, id_offre_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix_option VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D035FA871C13BCCF (id_offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE prestation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE prestation_offre (prestation_id INT NOT NULL, offre_id INT NOT NULL, INDEX IDX_6D0DCDEE9E45C554 (prestation_id), INDEX IDX_6D0DCDEE4CC8505A (offre_id), PRIMARY KEY(prestation_id, offre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE contrat_prestation ADD CONSTRAINT FK_ECFE7AC69E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contrat_prestation ADD CONSTRAINT FK_ECFE7AC61823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE options ADD CONSTRAINT FK_D035FA871C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE prestation_offre ADD CONSTRAINT FK_6D0DCDEE9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestation_offre ADD CONSTRAINT FK_6D0DCDEE4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993597DF5D4');
        $this->addSql('DROP INDEX IDX_60349993597DF5D4 ON contrat');
        $this->addSql('ALTER TABLE contrat ADD nom VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, DROP id_societe_id, DROP date_crea');
    }
}
