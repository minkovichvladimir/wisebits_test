<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210905190946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE blocks_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "users_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE action_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE blocks (id INT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "users" (id INT NOT NULL, name VARCHAR(64) NOT NULL, email VARCHAR(256) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, notes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE action_log (id INT NOT NULL, source VARCHAR(255) NOT NULL, action VARCHAR(255) NOT NULL, before TEXT DEFAULT NULL, after TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX users_email_uindex ON "users" (email)');
        $this->addSql('CREATE UNIQUE INDEX users_name_uindex ON "users" (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE blocks_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "users_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE action_log_id_seq CASCADE');
        $this->addSql('DROP TABLE blocks');
        $this->addSql('DROP TABLE "users"');
        $this->addSql('DROP TABLE action_log');
    }
}
