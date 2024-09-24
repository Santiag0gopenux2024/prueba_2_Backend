<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924213056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participation (id INT NOT NULL, student_id INT NOT NULL, research_project_id INT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, estimated_end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, actual_end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AB55E24FCB944F1A ON participation (student_id)');
        $this->addSql('CREATE INDEX IDX_AB55E24FD27719F4 ON participation (research_project_id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FD27719F4 FOREIGN KEY (research_project_id) REFERENCES research_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE participation DROP CONSTRAINT FK_AB55E24FCB944F1A');
        $this->addSql('ALTER TABLE participation DROP CONSTRAINT FK_AB55E24FD27719F4');
        $this->addSql('DROP TABLE participation');
    }
}
