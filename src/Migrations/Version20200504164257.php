<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504164257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE nb_pers (id INT AUTO_INCREMENT NOT NULL, nb INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE difficulte (id INT AUTO_INCREMENT NOT NULL, level VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_recette (categorie_id INT NOT NULL, recette_id INT NOT NULL, INDEX IDX_1638CD32BCF5E72D (categorie_id), INDEX IDX_1638CD3289312FE9 (recette_id), PRIMARY KEY(categorie_id, recette_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, contenu LONGTEXT NOT NULL, actif TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, rgpd TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gout (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gout_recette (gout_id INT NOT NULL, recette_id INT NOT NULL, INDEX IDX_1CDA09766B054CC (gout_id), INDEX IDX_1CDA09789312FE9 (recette_id), PRIMARY KEY(gout_id, recette_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, nb_pers_id INT DEFAULT NULL, difficulte_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, img360 VARCHAR(255) NOT NULL, note LONGTEXT NOT NULL, tps_repos INT NOT NULL, tps_prepa INT NOT NULL, tps_cuisson INT NOT NULL, tps_congel INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, process LONGTEXT NOT NULL, ingredients LONGTEXT NOT NULL, INDEX IDX_49BB63905FEFAC0 (nb_pers_id), INDEX IDX_49BB6390E6357589 (difficulte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_recette ADD CONSTRAINT FK_1638CD32BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_recette ADD CONSTRAINT FK_1638CD3289312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gout_recette ADD CONSTRAINT FK_1CDA09766B054CC FOREIGN KEY (gout_id) REFERENCES gout (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gout_recette ADD CONSTRAINT FK_1CDA09789312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB63905FEFAC0 FOREIGN KEY (nb_pers_id) REFERENCES nb_pers (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390E6357589 FOREIGN KEY (difficulte_id) REFERENCES difficulte (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB63905FEFAC0');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390E6357589');
        $this->addSql('ALTER TABLE categorie_recette DROP FOREIGN KEY FK_1638CD32BCF5E72D');
        $this->addSql('ALTER TABLE gout_recette DROP FOREIGN KEY FK_1CDA09766B054CC');
        $this->addSql('ALTER TABLE categorie_recette DROP FOREIGN KEY FK_1638CD3289312FE9');
        $this->addSql('ALTER TABLE gout_recette DROP FOREIGN KEY FK_1CDA09789312FE9');
        $this->addSql('DROP TABLE nb_pers');
        $this->addSql('DROP TABLE difficulte');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE categorie_recette');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE gout');
        $this->addSql('DROP TABLE gout_recette');
        $this->addSql('DROP TABLE recette');
    }
}
