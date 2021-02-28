<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210228100329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boardgames_list_boardgame DROP FOREIGN KEY FK_A8232DFC15F240B9');
        $this->addSql('DROP TABLE boardgames_list');
        $this->addSql('DROP TABLE boardgames_list_boardgame');
        $this->addSql('DROP TABLE user_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boardgames_list (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_A40169F7F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE boardgames_list_boardgame (boardgames_list_id INT NOT NULL, boardgame_id INT NOT NULL, INDEX IDX_A8232DFC15F240B9 (boardgames_list_id), INDEX IDX_A8232DFCB1A27A21 (boardgame_id), PRIMARY KEY(boardgames_list_id, boardgame_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_F7129A803AD8644E (user_source), INDEX IDX_F7129A80233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE boardgames_list ADD CONSTRAINT FK_A40169F7F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE boardgames_list_boardgame ADD CONSTRAINT FK_A8232DFC15F240B9 FOREIGN KEY (boardgames_list_id) REFERENCES boardgames_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boardgames_list_boardgame ADD CONSTRAINT FK_A8232DFCB1A27A21 FOREIGN KEY (boardgame_id) REFERENCES boardgame (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES user (id) ON DELETE CASCADE');
    }
}
