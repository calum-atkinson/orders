<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200927123250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO cinema.ticket_type (name, price) VALUES ("Standard", 790), ("Concession",540);');
        $this->addSql('INSERT INTO cinema.add_on_type (name, price) VALUES ("Real3D", 90), ("IMAX",150);');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('TRUNCATE TABLE cinema.ticket_type;');
        $this->addSql('TRUNCATE TABLE cinema.add_on_type;');
    }
}
