<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220807092256 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE degree_practitioner (degree_id INT NOT NULL, practitioner_id INT NOT NULL, INDEX IDX_6BB64882B35C5756 (degree_id), INDEX IDX_6BB648821121EA2C (practitioner_id), PRIMARY KEY(degree_id, practitioner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE degree_practitioner ADD CONSTRAINT FK_6BB64882B35C5756 FOREIGN KEY (degree_id) REFERENCES degree (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE degree_practitioner ADD CONSTRAINT FK_6BB648821121EA2C FOREIGN KEY (practitioner_id) REFERENCES practitioner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointment CHANGE status status ENUM(\'CONFIRMED_PRACTITIONER\',\'WAITING_PRACTITIONER\',\'CANCELLED_PRACTITIONER\',\'MODIFIED_PRACTITIONER\',\'CANCELLED_PATIENT\')');
        $this->addSql('ALTER TABLE availability CHANGE status status ENUM(\'OPEN\',\'BUSY\')');
        $this->addSql('ALTER TABLE degree DROP FOREIGN KEY FK_A7A36D631121EA2C');
        $this->addSql('DROP INDEX IDX_A7A36D631121EA2C ON degree');
        $this->addSql('ALTER TABLE degree DROP practitioner_id');
        $this->addSql('ALTER TABLE patient CHANGE gender gender ENUM(\'M\', \'F\'), CHANGE civility civility ENUM(\'Mr\', \'Mrs\', \'Ms\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE degree_practitioner');
        $this->addSql('ALTER TABLE appointment CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE availability CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE degree ADD practitioner_id INT NOT NULL');
        $this->addSql('ALTER TABLE degree ADD CONSTRAINT FK_A7A36D631121EA2C FOREIGN KEY (practitioner_id) REFERENCES practitioner (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A7A36D631121EA2C ON degree (practitioner_id)');
        $this->addSql('ALTER TABLE patient CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE civility civility VARCHAR(255) DEFAULT NULL');
    }
}
