<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522124601 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, access VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', date_first_connect DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_formations (user_id INT NOT NULL, formations_id INT NOT NULL, INDEX IDX_E7F7E7DBA76ED395 (user_id), INDEX IDX_E7F7E7DB3BF5B0C2 (formations_id), PRIMARY KEY(user_id, formations_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_formations ADD CONSTRAINT FK_E7F7E7DBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_formations ADD CONSTRAINT FK_E7F7E7DB3BF5B0C2 FOREIGN KEY (formations_id) REFERENCES formations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tutorials CHANGE chapter_id chapter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formations CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chapters CHANGE formation_id formation_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_formations DROP FOREIGN KEY FK_E7F7E7DBA76ED395');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_formations');
        $this->addSql('ALTER TABLE chapters CHANGE formation_id formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formations CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tutorials CHANGE chapter_id chapter_id INT DEFAULT NULL');
    }
}
