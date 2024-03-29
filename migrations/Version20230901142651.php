<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230901142651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `character` (id INT AUTO_INCREMENT NOT NULL, poster VARCHAR(255) NOT NULL, name VARCHAR(64) DEFAULT NULL, released_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT NOT NULL, quote VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comics (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(128) NOT NULL, poster VARCHAR(255) NOT NULL, released_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', synopsis LONGTEXT DEFAULT NULL, rarity SMALLINT DEFAULT NULL, INDEX IDX_2D56FB58F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comics_characters (comics_id INT NOT NULL, characters_id INT NOT NULL, INDEX IDX_1088B50271AE76A2 (comics_id), INDEX IDX_1088B502C70F0E28 (characters_id), PRIMARY KEY(comics_id, characters_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(64) NOT NULL, username VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_collection (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_5B2AA3DEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_collection_comics (user_collection_id INT NOT NULL, comics_id INT NOT NULL, INDEX IDX_276CB885BFC7FBAD (user_collection_id), INDEX IDX_276CB88571AE76A2 (comics_id), PRIMARY KEY(user_collection_id, comics_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wish_collection (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_B5E48822A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wish_collection_comics (wish_collection_id INT NOT NULL, comics_id INT NOT NULL, INDEX IDX_895C7D6C9B56329 (wish_collection_id), INDEX IDX_895C7D6C71AE76A2 (comics_id), PRIMARY KEY(wish_collection_id, comics_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comics ADD CONSTRAINT FK_2D56FB58F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE comics_characters ADD CONSTRAINT FK_1088B50271AE76A2 FOREIGN KEY (comics_id) REFERENCES comics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comics_characters ADD CONSTRAINT FK_1088B502C70F0E28 FOREIGN KEY (characters_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_collection ADD CONSTRAINT FK_5B2AA3DEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_collection_comics ADD CONSTRAINT FK_276CB885BFC7FBAD FOREIGN KEY (user_collection_id) REFERENCES user_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_collection_comics ADD CONSTRAINT FK_276CB88571AE76A2 FOREIGN KEY (comics_id) REFERENCES comics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wish_collection ADD CONSTRAINT FK_B5E48822A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wish_collection_comics ADD CONSTRAINT FK_895C7D6C9B56329 FOREIGN KEY (wish_collection_id) REFERENCES wish_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wish_collection_comics ADD CONSTRAINT FK_895C7D6C71AE76A2 FOREIGN KEY (comics_id) REFERENCES comics (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comics DROP FOREIGN KEY FK_2D56FB58F675F31B');
        $this->addSql('ALTER TABLE comics_characters DROP FOREIGN KEY FK_1088B50271AE76A2');
        $this->addSql('ALTER TABLE comics_characters DROP FOREIGN KEY FK_1088B502C70F0E28');
        $this->addSql('ALTER TABLE user_collection DROP FOREIGN KEY FK_5B2AA3DEA76ED395');
        $this->addSql('ALTER TABLE user_collection_comics DROP FOREIGN KEY FK_276CB885BFC7FBAD');
        $this->addSql('ALTER TABLE user_collection_comics DROP FOREIGN KEY FK_276CB88571AE76A2');
        $this->addSql('ALTER TABLE wish_collection DROP FOREIGN KEY FK_B5E48822A76ED395');
        $this->addSql('ALTER TABLE wish_collection_comics DROP FOREIGN KEY FK_895C7D6C9B56329');
        $this->addSql('ALTER TABLE wish_collection_comics DROP FOREIGN KEY FK_895C7D6C71AE76A2');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE `character`');
        $this->addSql('DROP TABLE comics');
        $this->addSql('DROP TABLE comics_characters');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_collection');
        $this->addSql('DROP TABLE user_collection_comics');
        $this->addSql('DROP TABLE wish_collection');
        $this->addSql('DROP TABLE wish_collection_comics');
    }
}
