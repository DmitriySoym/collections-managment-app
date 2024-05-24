<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240524151628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE custom_attribute (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(10) NOT NULL, INDEX IDX_B040985D12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE custom_attribute ADD CONSTRAINT FK_B040985D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category ADD catygory_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C12C29D3CC FOREIGN KEY (catygory_type_id) REFERENCES category_type (id)');
        $this->addSql('CREATE INDEX IDX_64C19C12C29D3CC ON category (catygory_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C12C29D3CC');
        $this->addSql('ALTER TABLE custom_attribute DROP FOREIGN KEY FK_B040985D12469DE2');
        $this->addSql('DROP TABLE category_type');
        $this->addSql('DROP TABLE custom_attribute');
        $this->addSql('DROP INDEX IDX_64C19C12C29D3CC ON category');
        $this->addSql('ALTER TABLE category DROP catygory_type_id');
    }
}
