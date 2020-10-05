<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201004160103 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users_lineup');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_lineup (users_id INT NOT NULL, lineup_id INT NOT NULL, INDEX IDX_C299805A67B3B43D (users_id), INDEX IDX_C299805AD347A7DE (lineup_id), PRIMARY KEY(users_id, lineup_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE users_lineup ADD CONSTRAINT FK_C299805A67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_lineup ADD CONSTRAINT FK_C299805AD347A7DE FOREIGN KEY (lineup_id) REFERENCES lineup (id) ON DELETE CASCADE');
    }
}
