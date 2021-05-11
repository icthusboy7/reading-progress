<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210208171827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE dev_devotional_reading_entity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE dev_devotional_reading (entity_id INT NOT NULL, devotional_id UUID NOT NULL, read_date_date_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, last_opened_date_date_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(entity_id))');
        $this->addSql('COMMENT ON COLUMN dev_devotional_reading.read_date_date_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN dev_devotional_reading.last_opened_date_date_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE dev_reading_progress (id UUID NOT NULL, plan_id UUID NOT NULL, last_opened_date_date_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, start_date_date_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_date_date_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, reader_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN dev_reading_progress.last_opened_date_date_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN dev_reading_progress.start_date_date_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN dev_reading_progress.end_date_date_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE dev_reading_progress_devotional_reading (reading_progress_id UUID NOT NULL, devotional_reading_id INT NOT NULL, PRIMARY KEY(reading_progress_id, devotional_reading_id))');
        $this->addSql('CREATE INDEX IDX_EB511CE9AA493D29 ON dev_reading_progress_devotional_reading (reading_progress_id)');
        $this->addSql('CREATE INDEX IDX_EB511CE9C6096F3F ON dev_reading_progress_devotional_reading (devotional_reading_id)');
        $this->addSql('ALTER TABLE dev_reading_progress_devotional_reading ADD CONSTRAINT FK_EB511CE9AA493D29 FOREIGN KEY (reading_progress_id) REFERENCES dev_reading_progress (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dev_reading_progress_devotional_reading ADD CONSTRAINT FK_EB511CE9C6096F3F FOREIGN KEY (devotional_reading_id) REFERENCES dev_devotional_reading (entity_id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE dev_reading_progress_devotional_reading DROP CONSTRAINT FK_EB511CE9C6096F3F');
        $this->addSql('ALTER TABLE dev_reading_progress_devotional_reading DROP CONSTRAINT FK_EB511CE9AA493D29');
        $this->addSql('DROP SEQUENCE dev_devotional_reading_entity_id_seq CASCADE');
        $this->addSql('DROP TABLE dev_devotional_reading');
        $this->addSql('DROP TABLE dev_reading_progress');
        $this->addSql('DROP TABLE dev_reading_progress_devotional_reading');
    }
}
