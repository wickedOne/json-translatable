<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217061718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE TranslatableJson (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(2000) DEFAULT NULL, translations JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE TranslatableJsonFiltered (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(2000) DEFAULT NULL, translations JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE TranslatableJson');
        $this->addSql('DROP TABLE TranslatableJsonFiltered');
    }
}
