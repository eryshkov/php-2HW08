<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190502121121 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE word_list ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE word_list ADD CONSTRAINT FK_4C5DFBF5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4C5DFBF5A76ED395 ON word_list (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE word_list DROP FOREIGN KEY FK_4C5DFBF5A76ED395');
        $this->addSql('DROP INDEX IDX_4C5DFBF5A76ED395 ON word_list');
        $this->addSql('ALTER TABLE word_list DROP user_id');
    }
}
