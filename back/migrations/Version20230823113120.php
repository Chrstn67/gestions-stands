<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230823113120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, reserve_id INT DEFAULT NULL, statut_resa INT NOT NULL, partner VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_42C849555913AEBF (reserve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_schedule (reservation_id INT NOT NULL, schedule_id INT NOT NULL, INDEX IDX_C78DF3EFB83297E7 (reservation_id), INDEX IDX_C78DF3EFA40BC2D5 (schedule_id), PRIMARY KEY(reservation_id, schedule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, has_id INT DEFAULT NULL, stand_id INT DEFAULT NULL, calendar_date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, statut_schedule INT NOT NULL, UNIQUE INDEX UNIQ_5A3811FB11BD6139 (has_id), INDEX IDX_5A3811FB9734D487 (stand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule_reservation (schedule_id INT NOT NULL, reservation_id INT NOT NULL, INDEX IDX_DA4AA39EA40BC2D5 (schedule_id), INDEX IDX_DA4AA39EB83297E7 (reservation_id), PRIMARY KEY(schedule_id, reservation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stand (id INT AUTO_INCREMENT NOT NULL, location VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stand_user (stand_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_11824FAA9734D487 (stand_id), INDEX IDX_11824FAAA76ED395 (user_id), PRIMARY KEY(stand_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_stand (user_id INT NOT NULL, stand_id INT NOT NULL, INDEX IDX_867BE3EEA76ED395 (user_id), INDEX IDX_867BE3EE9734D487 (stand_id), PRIMARY KEY(user_id, stand_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_reservation (user_id INT NOT NULL, reservation_id INT NOT NULL, INDEX IDX_EBD380C0A76ED395 (user_id), INDEX IDX_EBD380C0B83297E7 (reservation_id), PRIMARY KEY(user_id, reservation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849555913AEBF FOREIGN KEY (reserve_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation_schedule ADD CONSTRAINT FK_C78DF3EFB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_schedule ADD CONSTRAINT FK_C78DF3EFA40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB11BD6139 FOREIGN KEY (has_id) REFERENCES stand (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB9734D487 FOREIGN KEY (stand_id) REFERENCES stand (id)');
        $this->addSql('ALTER TABLE schedule_reservation ADD CONSTRAINT FK_DA4AA39EA40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE schedule_reservation ADD CONSTRAINT FK_DA4AA39EB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stand_user ADD CONSTRAINT FK_11824FAA9734D487 FOREIGN KEY (stand_id) REFERENCES stand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stand_user ADD CONSTRAINT FK_11824FAAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_stand ADD CONSTRAINT FK_867BE3EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_stand ADD CONSTRAINT FK_867BE3EE9734D487 FOREIGN KEY (stand_id) REFERENCES stand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_reservation ADD CONSTRAINT FK_EBD380C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_reservation ADD CONSTRAINT FK_EBD380C0B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849555913AEBF');
        $this->addSql('ALTER TABLE reservation_schedule DROP FOREIGN KEY FK_C78DF3EFB83297E7');
        $this->addSql('ALTER TABLE reservation_schedule DROP FOREIGN KEY FK_C78DF3EFA40BC2D5');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB11BD6139');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB9734D487');
        $this->addSql('ALTER TABLE schedule_reservation DROP FOREIGN KEY FK_DA4AA39EA40BC2D5');
        $this->addSql('ALTER TABLE schedule_reservation DROP FOREIGN KEY FK_DA4AA39EB83297E7');
        $this->addSql('ALTER TABLE stand_user DROP FOREIGN KEY FK_11824FAA9734D487');
        $this->addSql('ALTER TABLE stand_user DROP FOREIGN KEY FK_11824FAAA76ED395');
        $this->addSql('ALTER TABLE user_stand DROP FOREIGN KEY FK_867BE3EEA76ED395');
        $this->addSql('ALTER TABLE user_stand DROP FOREIGN KEY FK_867BE3EE9734D487');
        $this->addSql('ALTER TABLE user_reservation DROP FOREIGN KEY FK_EBD380C0A76ED395');
        $this->addSql('ALTER TABLE user_reservation DROP FOREIGN KEY FK_EBD380C0B83297E7');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_schedule');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE schedule_reservation');
        $this->addSql('DROP TABLE stand');
        $this->addSql('DROP TABLE stand_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_stand');
        $this->addSql('DROP TABLE user_reservation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
