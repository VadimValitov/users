<?php

declare(strict_types=1);

namespace Finbia\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230205125244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE user (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(64) NOT NULL,
                email VARCHAR(256) NOT NULL,
                created DATETIME NOT NULL,
                deleted DATETIME DEFAULT NULL,
                notes TEXT DEFAULT NULL,
                UNIQUE INDEX users_email_uindex (email),
                UNIQUE INDEX users_name_uindex (name),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
    }
}
