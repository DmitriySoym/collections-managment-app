<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516063707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_collection DROP CONSTRAINT fk_2b26caa6291a82dc');
        $this->addSql('DROP INDEX uniq_2b26caa6291a82dc');
        $this->addSql('ALTER TABLE users_collection DROP user_name_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users_collection ADD user_name_id INT NOT NULL');
        $this->addSql('ALTER TABLE users_collection ADD CONSTRAINT fk_2b26caa6291a82dc FOREIGN KEY (user_name_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_2b26caa6291a82dc ON users_collection (user_name_id)');
    }
}
