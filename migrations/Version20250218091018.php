<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218091018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Translatable (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(2000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE TranslatableJson (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(2000) DEFAULT NULL, translations JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE TranslatableJsonFiltered (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(2000) DEFAULT NULL, translations JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE Translations (id INT AUTO_INCREMENT NOT NULL, tableName VARCHAR(255) NOT NULL, recordId INT UNSIGNED NOT NULL, field VARCHAR(64) NOT NULL, value VARCHAR(2000) NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_record_id_table_name_field (recordId, tableName, field), INDEX IDX_table_name_field (tableName, field), INDEX IDX_table_name_locale_code_record_id (tableName, locale, recordId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Translatable');
        $this->addSql('DROP TABLE TranslatableJson');
        $this->addSql('DROP TABLE TranslatableJsonFiltered');
        $this->addSql('DROP TABLE Translations');
    }
}
