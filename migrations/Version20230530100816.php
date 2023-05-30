<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530100816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts CHANGE auteur auteur VARCHAR(50) NOT NULL, CHANGE titre titre VARCHAR(100) NOT NULL, CHANGE description description VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE slider CHANGE titre titre VARCHAR(100) NOT NULL, CHANGE description description VARCHAR(150) NOT NULL, CHANGE alt alt VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts CHANGE auteur auteur VARCHAR(255) NOT NULL, CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE slider CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE alt alt VARCHAR(255) NOT NULL');
    }
}
