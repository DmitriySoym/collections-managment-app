<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530113045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE itemcs_collection_attribute_value_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE item_attribute_string_field_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item_attribute_string_field (id INT NOT NULL, item_id INT NOT NULL, custom_item_attribute_id INT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_76051DC126F525E ON item_attribute_string_field (item_id)');
        $this->addSql('CREATE INDEX IDX_76051DC8BF3B7B6 ON item_attribute_string_field (custom_item_attribute_id)');
        $this->addSql('ALTER TABLE item_attribute_string_field ADD CONSTRAINT FK_76051DC126F525E FOREIGN KEY (item_id) REFERENCES category_collection (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_attribute_string_field ADD CONSTRAINT FK_76051DC8BF3B7B6 FOREIGN KEY (custom_item_attribute_id) REFERENCES custom_attribute (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE itemcs_collection_attribute_value DROP CONSTRAINT fk_7da05ff2b6e62efa');
        $this->addSql('ALTER TABLE itemcs_collection_attribute_value DROP CONSTRAINT fk_7da05ff2bde5fe26');
        $this->addSql('DROP TABLE itemcs_collection_attribute_value');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE item_attribute_string_field_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE itemcs_collection_attribute_value_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE itemcs_collection_attribute_value (id INT NOT NULL, attribute_id INT NOT NULL, item_collection_id INT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_7da05ff2bde5fe26 ON itemcs_collection_attribute_value (item_collection_id)');
        $this->addSql('CREATE INDEX idx_7da05ff2b6e62efa ON itemcs_collection_attribute_value (attribute_id)');
        $this->addSql('ALTER TABLE itemcs_collection_attribute_value ADD CONSTRAINT fk_7da05ff2b6e62efa FOREIGN KEY (attribute_id) REFERENCES custom_attribute (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE itemcs_collection_attribute_value ADD CONSTRAINT fk_7da05ff2bde5fe26 FOREIGN KEY (item_collection_id) REFERENCES category_collection (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_attribute_string_field DROP CONSTRAINT FK_76051DC126F525E');
        $this->addSql('ALTER TABLE item_attribute_string_field DROP CONSTRAINT FK_76051DC8BF3B7B6');
        $this->addSql('DROP TABLE item_attribute_string_field');
    }
}
