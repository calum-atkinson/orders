<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200927095709 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE add_on (id INT AUTO_INCREMENT NOT NULL, ticket_id INT NOT NULL, add_on_type_id_id INT NOT NULL, UNIQUE INDEX UNIQ_85139E3F700047D2 (ticket_id), UNIQUE INDEX UNIQ_85139E3FF8651B52 (add_on_type_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE add_on_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE add_on ADD CONSTRAINT FK_85139E3F700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE add_on ADD CONSTRAINT FK_85139E3FF8651B52 FOREIGN KEY (add_on_type_id_id) REFERENCES add_on_type (id)');
        $this->addSql('ALTER TABLE ticket_type DROP FOREIGN KEY FK_BE054211700047D2');
        $this->addSql('DROP INDEX UNIQ_BE054211700047D2 ON ticket_type');
        $this->addSql('ALTER TABLE ticket_type DROP ticket');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE add_on DROP FOREIGN KEY FK_85139E3FF8651B52');
        $this->addSql('DROP TABLE add_on');
        $this->addSql('DROP TABLE add_on_type');
        $this->addSql('ALTER TABLE ticket_type ADD ticket INT NOT NULL');
        $this->addSql('ALTER TABLE ticket_type ADD CONSTRAINT FK_BE054211700047D2 FOREIGN KEY (ticket) REFERENCES ticket (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BE054211700047D2 ON ticket_type (ticket)');
    }
}
