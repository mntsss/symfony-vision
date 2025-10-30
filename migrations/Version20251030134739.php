<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251030134739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE option_parameter (id_option_parameter SERIAL NOT NULL, name VARCHAR(255) NOT NULL, level INT NOT NULL, PRIMARY KEY(id_option_parameter))');
        $this->addSql('CREATE TABLE option_value (id_option_value SERIAL NOT NULL, id_option_parameter INT NOT NULL, value VARCHAR(255) NOT NULL, uuid UUID DEFAULT NULL, PRIMARY KEY(id_option_value))');
        $this->addSql('CREATE INDEX IDX_249CE55C1886D441 ON option_value (id_option_parameter)');
        $this->addSql('CREATE TABLE option_value_relation (id_option_value_relation SERIAL NOT NULL, id_option_value_parent INT NOT NULL, id_option_value_child INT NOT NULL, PRIMARY KEY(id_option_value_relation))');
        $this->addSql('CREATE INDEX IDX_A74AC0261B0DE08D ON option_value_relation (id_option_value_parent)');
        $this->addSql('CREATE INDEX IDX_A74AC02678033A19 ON option_value_relation (id_option_value_child)');
        $this->addSql('ALTER TABLE option_value ADD CONSTRAINT FK_249CE55C1886D441 FOREIGN KEY (id_option_parameter) REFERENCES option_parameter (id_option_parameter) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE option_value_relation ADD CONSTRAINT FK_A74AC0261B0DE08D FOREIGN KEY (id_option_value_parent) REFERENCES option_value (id_option_value) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE option_value_relation ADD CONSTRAINT FK_A74AC02678033A19 FOREIGN KEY (id_option_value_child) REFERENCES option_value (id_option_value) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE option_value DROP CONSTRAINT FK_249CE55C1886D441');
        $this->addSql('ALTER TABLE option_value_relation DROP CONSTRAINT FK_A74AC0261B0DE08D');
        $this->addSql('ALTER TABLE option_value_relation DROP CONSTRAINT FK_A74AC02678033A19');
        $this->addSql('DROP TABLE option_parameter');
        $this->addSql('DROP TABLE option_value');
        $this->addSql('DROP TABLE option_value_relation');
    }
}
