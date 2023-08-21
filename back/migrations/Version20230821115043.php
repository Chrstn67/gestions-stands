<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821115043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations ADD chosse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA2395B2BD0AE FOREIGN KEY (chosse_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4DA2395B2BD0AE ON reservations (chosse_id)');
        $this->addSql('ALTER TABLE schedules ADD has_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE schedules ADD CONSTRAINT FK_313BDC8E11BD6139 FOREIGN KEY (has_id) REFERENCES reservations (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_313BDC8E11BD6139 ON schedules (has_id)');
        $this->addSql('ALTER TABLE stands ADD run_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stands ADD CONSTRAINT FK_396860AA84E3FEC4 FOREIGN KEY (run_id) REFERENCES reservations (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_396860AA84E3FEC4 ON stands (run_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA2395B2BD0AE');
        $this->addSql('DROP INDEX UNIQ_4DA2395B2BD0AE ON reservations');
        $this->addSql('ALTER TABLE reservations DROP chosse_id');
        $this->addSql('ALTER TABLE schedules DROP FOREIGN KEY FK_313BDC8E11BD6139');
        $this->addSql('DROP INDEX UNIQ_313BDC8E11BD6139 ON schedules');
        $this->addSql('ALTER TABLE schedules DROP has_id');
        $this->addSql('ALTER TABLE stands DROP FOREIGN KEY FK_396860AA84E3FEC4');
        $this->addSql('DROP INDEX UNIQ_396860AA84E3FEC4 ON stands');
        $this->addSql('ALTER TABLE stands DROP run_id');
    }
}
