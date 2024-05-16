<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516090018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_collection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE category_collection (id INT NOT NULL, categoty_id_id INT NOT NULL, user_id_id INT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DA53354C5118D899 ON category_collection (categoty_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA53354C9D86650F ON category_collection (user_id_id)');
        $this->addSql('ALTER TABLE category_collection ADD CONSTRAINT FK_DA53354C5118D899 FOREIGN KEY (categoty_id_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_collection ADD CONSTRAINT FK_DA53354C9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_collection_id_seq CASCADE');
        $this->addSql('ALTER TABLE category_collection DROP CONSTRAINT FK_DA53354C5118D899');
        $this->addSql('ALTER TABLE category_collection DROP CONSTRAINT FK_DA53354C9D86650F');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_collection');
    }
}
