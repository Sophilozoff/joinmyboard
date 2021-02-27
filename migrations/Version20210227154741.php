<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227154741 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boardgames_list (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_A40169F7F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE boardgames_list_boardgame (boardgames_list_id INT NOT NULL, boardgame_id INT NOT NULL, INDEX IDX_A8232DFC15F240B9 (boardgames_list_id), INDEX IDX_A8232DFCB1A27A21 (boardgame_id), PRIMARY KEY(boardgames_list_id, boardgame_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boardgames_list ADD CONSTRAINT FK_A40169F7F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE boardgames_list_boardgame ADD CONSTRAINT FK_A8232DFC15F240B9 FOREIGN KEY (boardgames_list_id) REFERENCES boardgames_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boardgames_list_boardgame ADD CONSTRAINT FK_A8232DFCB1A27A21 FOREIGN KEY (boardgame_id) REFERENCES boardgame (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boardgames_list_boardgame DROP FOREIGN KEY FK_A8232DFC15F240B9');
        $this->addSql('DROP TABLE boardgames_list');
        $this->addSql('DROP TABLE boardgames_list_boardgame');
    }
}
