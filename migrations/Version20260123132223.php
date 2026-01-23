<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260123132223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chantier DROP FOREIGN KEY `FK_636F27F6D0C0049D`');
        $this->addSql('DROP INDEX IDX_636F27F6D0C0049D ON chantier');
        $this->addSql('ALTER TABLE chantier DROP chantier_id');
        $this->addSql('ALTER TABLE equipe ADD indice DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chantier ADD chantier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chantier ADD CONSTRAINT `FK_636F27F6D0C0049D` FOREIGN KEY (chantier_id) REFERENCES equipe (id)');
        $this->addSql('CREATE INDEX IDX_636F27F6D0C0049D ON chantier (chantier_id)');
        $this->addSql('ALTER TABLE equipe DROP indice');
    }
}
