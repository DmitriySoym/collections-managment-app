<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240523115037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE custom_item_attribute (id INT AUTO_INCREMENT NOT NULL, category_collection_id INT NOT NULL, value VARCHAR(500) NOT NULL, type VARCHAR(30) NOT NULL, INDEX IDX_DC45CCD14F9273B6 (category_collection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE custom_item_attribute ADD CONSTRAINT FK_DC45CCD14F9273B6 FOREIGN KEY (category_collection_id) REFERENCES category_collection (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE custom_item_attribute DROP FOREIGN KEY FK_DC45CCD14F9273B6');
        $this->addSql('DROP TABLE custom_item_attribute');
    }
}
