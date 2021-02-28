<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210228145525 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_boardgame (event_id INT NOT NULL, boardgame_id INT NOT NULL, INDEX IDX_1E34E52071F7E88B (event_id), INDEX IDX_1E34E520B1A27A21 (boardgame_id), PRIMARY KEY(event_id, boardgame_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_boardgame ADD CONSTRAINT FK_1E34E52071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_boardgame ADD CONSTRAINT FK_1E34E520B1A27A21 FOREIGN KEY (boardgame_id) REFERENCES boardgame (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event_boardgame');
    }
}
