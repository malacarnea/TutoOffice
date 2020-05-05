<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200505100215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tutorials CHANGE chapter_id chapter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formations DROP level, CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chapters CHANGE formation_id formation_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE chapters CHANGE formation_id formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formations ADD level INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tutorials CHANGE chapter_id chapter_id INT DEFAULT NULL');
    }
}
