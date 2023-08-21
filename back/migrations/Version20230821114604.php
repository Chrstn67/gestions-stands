<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821114604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedules ADD schedules_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE schedules ADD CONSTRAINT FK_313BDC8E116C90BC FOREIGN KEY (schedules_id) REFERENCES reservations (id)');
        $this->addSql('CREATE INDEX IDX_313BDC8E116C90BC ON schedules (schedules_id)');
        $this->addSql('ALTER TABLE stands ADD reservations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stands ADD CONSTRAINT FK_396860AAD9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservations (id)');
        $this->addSql('CREATE INDEX IDX_396860AAD9A7F869 ON stands (reservations_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedules DROP FOREIGN KEY FK_313BDC8E116C90BC');
        $this->addSql('DROP INDEX IDX_313BDC8E116C90BC ON schedules');
        $this->addSql('ALTER TABLE schedules DROP schedules_id');
        $this->addSql('ALTER TABLE stands DROP FOREIGN KEY FK_396860AAD9A7F869');
        $this->addSql('DROP INDEX IDX_396860AAD9A7F869 ON stands');
        $this->addSql('ALTER TABLE stands DROP reservations_id');
    }
}
