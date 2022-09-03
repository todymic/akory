<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220808184130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, practitioner_id INT NOT NULL, patient_id INT NOT NULL, reason_id INT DEFAULT NULL, availability_id INT NOT NULL, status ENUM(\'CONFIRMED_PRACTITIONER\',\'WAITING_PRACTITIONER\',\'CANCELLED_PRACTITIONER\',\'MODIFIED_PRACTITIONER\',\'CANCELLED_PATIENT\'), description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_FE38F8441121EA2C (practitioner_id), INDEX IDX_FE38F8446B899279 (patient_id), UNIQUE INDEX UNIQ_FE38F84459BB1592 (reason_id), UNIQUE INDEX UNIQ_FE38F84461778466 (availability_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE availability (id INT AUTO_INCREMENT NOT NULL, practitioner_id INT NOT NULL, location_id INT DEFAULT NULL, day DATE NOT NULL, hour TIME NOT NULL, status ENUM(\'OPEN\',\'BUSY\'), INDEX IDX_3FB7A2BF1121EA2C (practitioner_id), INDEX IDX_3FB7A2BF64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, street_type VARCHAR(255) NOT NULL, street_name VARCHAR(255) NOT NULL, zipcode INT NOT NULL, street_number INT NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE practitioners_locations (practitioner_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_E450585B1121EA2C (practitioner_id), INDEX IDX_E450585B64D218E (location_id), PRIMARY KEY(practitioner_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, gender ENUM(\'M\', \'F\'), civility ENUM(\'Mr\', \'Mrs\', \'Ms\'), birthday DATE NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1ADAD7EBE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE practitioner (id INT AUTO_INCREMENT NOT NULL, languages LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', description LONGTEXT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_17323CBCE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE practitioners_specialities (speciality_id INT NOT NULL, practitioner_id INT NOT NULL, INDEX IDX_D79371F3B5A08D7 (speciality_id), INDEX IDX_D79371F1121EA2C (practitioner_id), PRIMARY KEY(speciality_id, practitioner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reason (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, constant VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_3BB8880C12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8441121EA2C FOREIGN KEY (practitioner_id) REFERENCES practitioner (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8446B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84459BB1592 FOREIGN KEY (reason_id) REFERENCES reason (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84461778466 FOREIGN KEY (availability_id) REFERENCES availability (id)');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BF1121EA2C FOREIGN KEY (practitioner_id) REFERENCES practitioner (id)');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BF64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE practitioners_locations ADD CONSTRAINT FK_E450585B1121EA2C FOREIGN KEY (practitioner_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE practitioners_locations ADD CONSTRAINT FK_E450585B64D218E FOREIGN KEY (location_id) REFERENCES practitioner (id)');
        $this->addSql('ALTER TABLE practitioners_specialities ADD CONSTRAINT FK_D79371F3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES practitioner (id)');
        $this->addSql('ALTER TABLE practitioners_specialities ADD CONSTRAINT FK_D79371F1121EA2C FOREIGN KEY (practitioner_id) REFERENCES speciality (id)');
        $this->addSql('ALTER TABLE reason ADD CONSTRAINT FK_3BB8880C12469DE2 FOREIGN KEY (category_id) REFERENCES speciality (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8441121EA2C');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8446B899279');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84459BB1592');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84461778466');
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BF1121EA2C');
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BF64D218E');
        $this->addSql('ALTER TABLE practitioners_locations DROP FOREIGN KEY FK_E450585B1121EA2C');
        $this->addSql('ALTER TABLE practitioners_locations DROP FOREIGN KEY FK_E450585B64D218E');
        $this->addSql('ALTER TABLE practitioners_specialities DROP FOREIGN KEY FK_D79371F3B5A08D7');
        $this->addSql('ALTER TABLE practitioners_specialities DROP FOREIGN KEY FK_D79371F1121EA2C');
        $this->addSql('ALTER TABLE reason DROP FOREIGN KEY FK_3BB8880C12469DE2');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE practitioners_locations');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE practitioner');
        $this->addSql('DROP TABLE practitioners_specialities');
        $this->addSql('DROP TABLE reason');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
