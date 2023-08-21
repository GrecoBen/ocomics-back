<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821172829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_collection_comics (user_collection_id INT NOT NULL, comics_id INT NOT NULL, INDEX IDX_276CB885BFC7FBAD (user_collection_id), INDEX IDX_276CB88571AE76A2 (comics_id), PRIMARY KEY(user_collection_id, comics_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_collection_comics ADD CONSTRAINT FK_276CB885BFC7FBAD FOREIGN KEY (user_collection_id) REFERENCES user_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_collection_comics ADD CONSTRAINT FK_276CB88571AE76A2 FOREIGN KEY (comics_id) REFERENCES comics (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_collection_comics DROP FOREIGN KEY FK_276CB885BFC7FBAD');
        $this->addSql('ALTER TABLE user_collection_comics DROP FOREIGN KEY FK_276CB88571AE76A2');
        $this->addSql('DROP TABLE user_collection_comics');
    }
}
