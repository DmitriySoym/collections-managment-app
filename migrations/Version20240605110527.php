<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605110527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "like_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "like" (id INT NOT NULL, user_liked_id INT NOT NULL, item_id INT NOT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AC6340B3260FC79 ON "like" (user_liked_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B3126F525E ON "like" (item_id)');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT FK_AC6340B3260FC79 FOREIGN KEY (user_liked_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT FK_AC6340B3126F525E FOREIGN KEY (item_id) REFERENCES category_collection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "like_id_seq" CASCADE');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT FK_AC6340B3260FC79');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT FK_AC6340B3126F525E');
        $this->addSql('DROP TABLE "like"');
    }
}
