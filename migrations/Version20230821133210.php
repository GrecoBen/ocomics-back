<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821133210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `character` (id INT AUTO_INCREMENT NOT NULL, alias VARCHAR(64) NOT NULL, name VARCHAR(64) DEFAULT NULL, released_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comics_characters (comics_id INT NOT NULL, characters_id INT NOT NULL, INDEX IDX_1088B50271AE76A2 (comics_id), INDEX IDX_1088B502C70F0E28 (characters_id), PRIMARY KEY(comics_id, characters_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comics_characters ADD CONSTRAINT FK_1088B50271AE76A2 FOREIGN KEY (comics_id) REFERENCES comics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comics_characters ADD CONSTRAINT FK_1088B502C70F0E28 FOREIGN KEY (characters_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE characters');
        $this->addSql('ALTER TABLE comics ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE comics ADD CONSTRAINT FK_2D56FB58F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_2D56FB58F675F31B ON comics (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE characters (id INT AUTO_INCREMENT NOT NULL, alias VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, released_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE comics_characters DROP FOREIGN KEY FK_1088B50271AE76A2');
        $this->addSql('ALTER TABLE comics_characters DROP FOREIGN KEY FK_1088B502C70F0E28');
        $this->addSql('DROP TABLE `character`');
        $this->addSql('DROP TABLE comics_characters');
        $this->addSql('ALTER TABLE comics DROP FOREIGN KEY FK_2D56FB58F675F31B');
        $this->addSql('DROP INDEX IDX_2D56FB58F675F31B ON comics');
        $this->addSql('ALTER TABLE comics DROP author_id');
    }
}
