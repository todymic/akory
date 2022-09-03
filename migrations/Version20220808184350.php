<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220808184350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment CHANGE status status ENUM(\'CONFIRMED_PRACTITIONER\',\'WAITING_PRACTITIONER\',\'CANCELLED_PRACTITIONER\',\'MODIFIED_PRACTITIONER\',\'CANCELLED_PATIENT\')');
        $this->addSql('ALTER TABLE availability CHANGE status status ENUM(\'OPEN\',\'BUSY\')');
        $this->addSql('ALTER TABLE patient CHANGE gender gender ENUM(\'M\', \'F\'), CHANGE civility civility ENUM(\'Mr\', \'Mrs\', \'Ms\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE patient CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE civility civility VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE appointment CHANGE status status VARCHAR(255) DEFAULT NULL');
    }
}
