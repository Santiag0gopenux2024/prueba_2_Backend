<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924143523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_ab55e24f22a50048');
        $this->addSql('ALTER TABLE participation ALTER research_code TYPE INT');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F22A50048 FOREIGN KEY (research_code) REFERENCES research_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AB55E24F22A50048 ON participation (research_code)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE participation DROP CONSTRAINT FK_AB55E24F22A50048');
        $this->addSql('DROP INDEX IDX_AB55E24F22A50048');
        $this->addSql('ALTER TABLE participation ALTER research_code TYPE VARCHAR(255)');
        $this->addSql('CREATE UNIQUE INDEX uniq_ab55e24f22a50048 ON participation (research_code)');
    }
}
