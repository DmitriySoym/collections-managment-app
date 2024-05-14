<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514133654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE item_collection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item_collection (id INT NOT NULL, collection_name_id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_41FC4D38253BEE07 ON item_collection (collection_name_id)');
        $this->addSql('ALTER TABLE item_collection ADD CONSTRAINT FK_41FC4D38253BEE07 FOREIGN KEY (collection_name_id) REFERENCES users_collection (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE item_collection_id_seq CASCADE');
        $this->addSql('ALTER TABLE item_collection DROP CONSTRAINT FK_41FC4D38253BEE07');
        $this->addSql('DROP TABLE item_collection');
    }
}
