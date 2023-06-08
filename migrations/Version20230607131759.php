<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230607131759 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE actions_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE articles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE articles (id INT NOT NULL, name VARCHAR(255) NOT NULL, body TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE actions');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE articles_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE actions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE actions (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE articles');
    }
}
