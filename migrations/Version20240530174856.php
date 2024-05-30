<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530174856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE item_attribute_integer_field_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE item_attribute_text_field_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item_attribute_integer_field (id INT NOT NULL, item_id INT NOT NULL, custom_item_attribute_id INT NOT NULL, value INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E1567D3F126F525E ON item_attribute_integer_field (item_id)');
        $this->addSql('CREATE INDEX IDX_E1567D3F8BF3B7B6 ON item_attribute_integer_field (custom_item_attribute_id)');
        $this->addSql('CREATE TABLE item_attribute_text_field (id INT NOT NULL, item_id INT NOT NULL, custom_item_attribute_id INT NOT NULL, value TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CD2B04B126F525E ON item_attribute_text_field (item_id)');
        $this->addSql('CREATE INDEX IDX_7CD2B04B8BF3B7B6 ON item_attribute_text_field (custom_item_attribute_id)');
        $this->addSql('ALTER TABLE item_attribute_integer_field ADD CONSTRAINT FK_E1567D3F126F525E FOREIGN KEY (item_id) REFERENCES category_collection (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_attribute_integer_field ADD CONSTRAINT FK_E1567D3F8BF3B7B6 FOREIGN KEY (custom_item_attribute_id) REFERENCES custom_attribute (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_attribute_text_field ADD CONSTRAINT FK_7CD2B04B126F525E FOREIGN KEY (item_id) REFERENCES category_collection (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_attribute_text_field ADD CONSTRAINT FK_7CD2B04B8BF3B7B6 FOREIGN KEY (custom_item_attribute_id) REFERENCES custom_attribute (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE item_attribute_integer_field_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE item_attribute_text_field_id_seq CASCADE');
        $this->addSql('ALTER TABLE item_attribute_integer_field DROP CONSTRAINT FK_E1567D3F126F525E');
        $this->addSql('ALTER TABLE item_attribute_integer_field DROP CONSTRAINT FK_E1567D3F8BF3B7B6');
        $this->addSql('ALTER TABLE item_attribute_text_field DROP CONSTRAINT FK_7CD2B04B126F525E');
        $this->addSql('ALTER TABLE item_attribute_text_field DROP CONSTRAINT FK_7CD2B04B8BF3B7B6');
        $this->addSql('DROP TABLE item_attribute_integer_field');
        $this->addSql('DROP TABLE item_attribute_text_field');
    }
}
