<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200927135614 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE add_on DROP FOREIGN KEY FK_85139E3FF8651B52');
        $this->addSql('DROP INDEX IDX_85139E3FF8651B52 ON add_on');
        $this->addSql('ALTER TABLE add_on CHANGE add_on_type_id_id add_on_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE add_on ADD CONSTRAINT FK_85139E3FAE5A6E89 FOREIGN KEY (add_on_type_id) REFERENCES add_on_type (id)');
        $this->addSql('CREATE INDEX IDX_85139E3FAE5A6E89 ON add_on (add_on_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE add_on DROP FOREIGN KEY FK_85139E3FAE5A6E89');
        $this->addSql('DROP INDEX IDX_85139E3FAE5A6E89 ON add_on');
        $this->addSql('ALTER TABLE add_on CHANGE add_on_type_id add_on_type_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE add_on ADD CONSTRAINT FK_85139E3FF8651B52 FOREIGN KEY (add_on_type_id_id) REFERENCES add_on_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_85139E3FF8651B52 ON add_on (add_on_type_id_id)');
    }
}
