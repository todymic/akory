<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220807122224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE degree_practitioner DROP FOREIGN KEY FK_6BB64882B35C5756');
        $this->addSql('DROP TABLE degree');
        $this->addSql('DROP TABLE degree_practitioner');
        $this->addSql('ALTER TABLE appointment CHANGE status status ENUM(\'CONFIRMED_PRACTITIONER\',\'WAITING_PRACTITIONER\',\'CANCELLED_PRACTITIONER\',\'MODIFIED_PRACTITIONER\',\'CANCELLED_PATIENT\')');
        $this->addSql('ALTER TABLE availability CHANGE status status ENUM(\'OPEN\',\'BUSY\')');
        $this->addSql('ALTER TABLE patient CHANGE gender gender ENUM(\'M\', \'F\'), CHANGE civility civility ENUM(\'Mr\', \'Mrs\', \'Ms\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE degree (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE degree_practitioner (id INT AUTO_INCREMENT NOT NULL, degree_id INT NOT NULL, practitioner_id INT NOT NULL, INDEX IDX_6BB648821121EA2C (practitioner_id), INDEX IDX_6BB64882B35C5756 (degree_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE degree_practitioner ADD CONSTRAINT FK_6BB648821121EA2C FOREIGN KEY (practitioner_id) REFERENCES practitioner (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE degree_practitioner ADD CONSTRAINT FK_6BB64882B35C5756 FOREIGN KEY (degree_id) REFERENCES degree (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE appointment CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE availability CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE patient CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE civility civility VARCHAR(255) DEFAULT NULL');
    }
}
