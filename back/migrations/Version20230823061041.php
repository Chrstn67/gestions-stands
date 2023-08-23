<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230823061041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, reserve_id INT DEFAULT NULL, statut_resa INT NOT NULL, partner VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_42C849555913AEBF (reserve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_schedule (reservation_id INT NOT NULL, schedule_id INT NOT NULL, INDEX IDX_C78DF3EFB83297E7 (reservation_id), INDEX IDX_C78DF3EFA40BC2D5 (schedule_id), PRIMARY KEY(reservation_id, schedule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, role INT NOT NULL, INDEX IDX_57698A6AFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, has_id INT DEFAULT NULL, stand_id INT DEFAULT NULL, calentar_date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, statut_schedule INT NOT NULL, UNIQUE INDEX UNIQ_5A3811FB11BD6139 (has_id), INDEX IDX_5A3811FB9734D487 (stand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule_reservation (schedule_id INT NOT NULL, reservation_id INT NOT NULL, INDEX IDX_DA4AA39EA40BC2D5 (schedule_id), INDEX IDX_DA4AA39EB83297E7 (reservation_id), PRIMARY KEY(schedule_id, reservation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stand (id INT AUTO_INCREMENT NOT NULL, location VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stand_utilisateur (stand_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_BF2B789C9734D487 (stand_id), INDEX IDX_BF2B789CFB88E14F (utilisateur_id), PRIMARY KEY(stand_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, INDEX IDX_1D1C63B3D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_stand (utilisateur_id INT NOT NULL, stand_id INT NOT NULL, INDEX IDX_A27C4068FB88E14F (utilisateur_id), INDEX IDX_A27C40689734D487 (stand_id), PRIMARY KEY(utilisateur_id, stand_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_reservation (utilisateur_id INT NOT NULL, reservation_id INT NOT NULL, INDEX IDX_B62E44C6FB88E14F (utilisateur_id), INDEX IDX_B62E44C6B83297E7 (reservation_id), PRIMARY KEY(utilisateur_id, reservation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849555913AEBF FOREIGN KEY (reserve_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation_schedule ADD CONSTRAINT FK_C78DF3EFB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_schedule ADD CONSTRAINT FK_C78DF3EFA40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB11BD6139 FOREIGN KEY (has_id) REFERENCES stand (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB9734D487 FOREIGN KEY (stand_id) REFERENCES stand (id)');
        $this->addSql('ALTER TABLE schedule_reservation ADD CONSTRAINT FK_DA4AA39EA40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE schedule_reservation ADD CONSTRAINT FK_DA4AA39EB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stand_utilisateur ADD CONSTRAINT FK_BF2B789C9734D487 FOREIGN KEY (stand_id) REFERENCES stand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stand_utilisateur ADD CONSTRAINT FK_BF2B789CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE utilisateur_stand ADD CONSTRAINT FK_A27C4068FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_stand ADD CONSTRAINT FK_A27C40689734D487 FOREIGN KEY (stand_id) REFERENCES stand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_reservation ADD CONSTRAINT FK_B62E44C6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_reservation ADD CONSTRAINT FK_B62E44C6B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849555913AEBF');
        $this->addSql('ALTER TABLE reservation_schedule DROP FOREIGN KEY FK_C78DF3EFB83297E7');
        $this->addSql('ALTER TABLE reservation_schedule DROP FOREIGN KEY FK_C78DF3EFA40BC2D5');
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6AFB88E14F');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB11BD6139');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB9734D487');
        $this->addSql('ALTER TABLE schedule_reservation DROP FOREIGN KEY FK_DA4AA39EA40BC2D5');
        $this->addSql('ALTER TABLE schedule_reservation DROP FOREIGN KEY FK_DA4AA39EB83297E7');
        $this->addSql('ALTER TABLE stand_utilisateur DROP FOREIGN KEY FK_BF2B789C9734D487');
        $this->addSql('ALTER TABLE stand_utilisateur DROP FOREIGN KEY FK_BF2B789CFB88E14F');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3D60322AC');
        $this->addSql('ALTER TABLE utilisateur_stand DROP FOREIGN KEY FK_A27C4068FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_stand DROP FOREIGN KEY FK_A27C40689734D487');
        $this->addSql('ALTER TABLE utilisateur_reservation DROP FOREIGN KEY FK_B62E44C6FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_reservation DROP FOREIGN KEY FK_B62E44C6B83297E7');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_schedule');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE schedule_reservation');
        $this->addSql('DROP TABLE stand');
        $this->addSql('DROP TABLE stand_utilisateur');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_stand');
        $this->addSql('DROP TABLE utilisateur_reservation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
