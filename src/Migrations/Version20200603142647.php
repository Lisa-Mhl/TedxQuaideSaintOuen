<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200603142647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, logo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stats (id INT AUTO_INCREMENT NOT NULL, attendees INT NOT NULL, speakers INT NOT NULL, user_reached INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, message LONGTEXT NOT NULL, subject VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, comment VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, job VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner (id INT AUTO_INCREMENT NOT NULL, photo VARCHAR(255) NOT NULL, title VARCHAR(50) NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, photo VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, job VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE talk (id INT AUTO_INCREMENT NOT NULL, video VARCHAR(255) DEFAULT NULL, title VARCHAR(50) NOT NULL, photo VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speaker (id INT AUTO_INCREMENT NOT NULL, photo VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, job VARCHAR(50) NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speaker_talk (speaker_id INT NOT NULL, talk_id INT NOT NULL, INDEX IDX_BC33BC93D04A0F27 (speaker_id), INDEX IDX_BC33BC936F0601D5 (talk_id), PRIMARY KEY(speaker_id, talk_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE legal_mentions (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE edito (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE footer (id INT AUTO_INCREMENT NOT NULL, logo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_talk (tag_id INT NOT NULL, talk_id INT NOT NULL, INDEX IDX_712B6A0DBAD26311 (tag_id), INDEX IDX_712B6A0D6F0601D5 (talk_id), PRIMARY KEY(tag_id, talk_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE speaker_talk ADD CONSTRAINT FK_BC33BC93D04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE speaker_talk ADD CONSTRAINT FK_BC33BC936F0601D5 FOREIGN KEY (talk_id) REFERENCES talk (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_talk ADD CONSTRAINT FK_712B6A0DBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_talk ADD CONSTRAINT FK_712B6A0D6F0601D5 FOREIGN KEY (talk_id) REFERENCES talk (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE speaker_talk DROP FOREIGN KEY FK_BC33BC936F0601D5');
        $this->addSql('ALTER TABLE tag_talk DROP FOREIGN KEY FK_712B6A0D6F0601D5');
        $this->addSql('ALTER TABLE speaker_talk DROP FOREIGN KEY FK_BC33BC93D04A0F27');
        $this->addSql('ALTER TABLE tag_talk DROP FOREIGN KEY FK_712B6A0DBAD26311');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE stats');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE banner');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE talk');
        $this->addSql('DROP TABLE speaker');
        $this->addSql('DROP TABLE speaker_talk');
        $this->addSql('DROP TABLE legal_mentions');
        $this->addSql('DROP TABLE edito');
        $this->addSql('DROP TABLE footer');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_talk');
    }
}
