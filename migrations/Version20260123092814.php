<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260123092814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chantier ADD equipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chantier ADD CONSTRAINT FK_636F27F66D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('CREATE INDEX IDX_636F27F66D861B89 ON chantier (equipe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chantier DROP FOREIGN KEY FK_636F27F66D861B89');
        $this->addSql('DROP INDEX IDX_636F27F66D861B89 ON chantier');
        $this->addSql('ALTER TABLE chantier DROP equipe_id');
    }
}
