<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924211305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_ab55e24f22a50048');
        $this->addSql('ALTER TABLE participation ADD research_project_id INT NOT NULL');
        $this->addSql('ALTER TABLE participation DROP research_code');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FD27719F4 FOREIGN KEY (research_project_id) REFERENCES research_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AB55E24FD27719F4 ON participation (research_project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE participation DROP CONSTRAINT FK_AB55E24FD27719F4');
        $this->addSql('DROP INDEX IDX_AB55E24FD27719F4');
        $this->addSql('ALTER TABLE participation ADD research_code VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE participation DROP research_project_id');
        $this->addSql('CREATE UNIQUE INDEX uniq_ab55e24f22a50048 ON participation (research_code)');
    }
}
