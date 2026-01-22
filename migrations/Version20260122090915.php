<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260122090915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chantier ADD surface_plancher DOUBLE PRECISION DEFAULT NULL, ADD surface_habitable DOUBLE PRECISION DEFAULT NULL, DROP surface_maison, DROP surface_combles, DROP chantier_id');
        $this->addSql('ALTER TABLE chantier_presta ADD CONSTRAINT FK_C49E4656D0C0049D FOREIGN KEY (chantier_id) REFERENCES chantier (id)');
        $this->addSql('ALTER TABLE chantier_presta ADD CONSTRAINT FK_C49E4656A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE chantier_presta ADD CONSTRAINT FK_C49E46566D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chantier ADD surface_maison DOUBLE PRECISION DEFAULT NULL, ADD surface_combles DOUBLE PRECISION DEFAULT NULL, ADD chantier_id INT DEFAULT NULL, DROP surface_plancher, DROP surface_habitable');
        $this->addSql('ALTER TABLE chantier_presta DROP FOREIGN KEY FK_C49E4656D0C0049D');
        $this->addSql('ALTER TABLE chantier_presta DROP FOREIGN KEY FK_C49E4656A0905086');
        $this->addSql('ALTER TABLE chantier_presta DROP FOREIGN KEY FK_C49E46566D861B89');
    }
}
