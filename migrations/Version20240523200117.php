<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240523200117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_collection DROP CONSTRAINT fk_da53354c9d86650f');
        $this->addSql('DROP INDEX uniq_da53354c9d86650f');
        $this->addSql('ALTER TABLE category_collection DROP user_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category_collection ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE category_collection ADD CONSTRAINT fk_da53354c9d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_da53354c9d86650f ON category_collection (user_id_id)');
    }
}
