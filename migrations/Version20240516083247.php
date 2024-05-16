<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516083247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE category_collection_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_collection_id_seq CASCADE');
        $this->addSql('ALTER TABLE category_collection DROP CONSTRAINT fk_da53354c253bee07');
        $this->addSql('DROP TABLE users_collection');
        $this->addSql('DROP TABLE category_collection');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE category_collection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_collection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users_collection (id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE category_collection (id INT NOT NULL, collection_name_id INT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_da53354c253bee07 ON category_collection (collection_name_id)');
        $this->addSql('ALTER TABLE category_collection ADD CONSTRAINT fk_da53354c253bee07 FOREIGN KEY (collection_name_id) REFERENCES users_collection (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
