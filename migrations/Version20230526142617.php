<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526142617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slider ADD image VARCHAR(255) DEFAULT NULL, DROP image_un, DROP image_deux, DROP image_trois');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slider ADD image_deux VARCHAR(255) DEFAULT NULL, ADD image_trois VARCHAR(255) DEFAULT NULL, CHANGE image image_un VARCHAR(255) DEFAULT NULL');
    }
}
