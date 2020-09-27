<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200927095051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket_type (id INT AUTO_INCREMENT NOT NULL, ticket INT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, UNIQUE INDEX UNIQ_BE054211700047D2 (ticket), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket_type ADD CONSTRAINT FK_BE054211700047D2 FOREIGN KEY (ticket) REFERENCES ticket (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ticket_type');
    }
}
