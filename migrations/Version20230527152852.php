<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230527152852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id SMALLINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, priority INT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, tour_id INT UNSIGNED DEFAULT NULL, text VARCHAR(255) NOT NULL, assessment SMALLINT NOT NULL, public TINYINT(1) NOT NULL, show_main_page TINYINT(1) NOT NULL, answer VARCHAR(255) DEFAULT NULL, INDEX IDX_794381C6F675F31B (author_id), INDEX IDX_794381C615ED8D43 (tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review_photo (id INT AUTO_INCREMENT NOT NULL, reviews_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_739A8038092D97F (reviews_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour_photos (id INT UNSIGNED AUTO_INCREMENT NOT NULL, tour_id INT UNSIGNED DEFAULT NULL, path VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, main TINYINT(1) NOT NULL, INDEX IDX_3DF8073315ED8D43 (tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tours (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price INT UNSIGNED NOT NULL, long_time VARCHAR(255) NOT NULL, complexity VARCHAR(255) NOT NULL, band_size INT UNSIGNED NOT NULL, content JSON NOT NULL, details JSON NOT NULL, created_at INT UNSIGNED NOT NULL, public TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour_category (tour_id INT UNSIGNED NOT NULL, category_id SMALLINT NOT NULL, INDEX IDX_9CB340F215ED8D43 (tour_id), INDEX IDX_9CB340F212469DE2 (category_id), PRIMARY KEY(tour_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6F675F31B FOREIGN KEY (author_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C615ED8D43 FOREIGN KEY (tour_id) REFERENCES tours (id)');
        $this->addSql('ALTER TABLE review_photo ADD CONSTRAINT FK_739A8038092D97F FOREIGN KEY (reviews_id) REFERENCES review (id)');
        $this->addSql('ALTER TABLE tour_photos ADD CONSTRAINT FK_3DF8073315ED8D43 FOREIGN KEY (tour_id) REFERENCES tours (id)');
        $this->addSql('ALTER TABLE tour_category ADD CONSTRAINT FK_9CB340F215ED8D43 FOREIGN KEY (tour_id) REFERENCES tours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tour_category ADD CONSTRAINT FK_9CB340F212469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6F675F31B');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C615ED8D43');
        $this->addSql('ALTER TABLE review_photo DROP FOREIGN KEY FK_739A8038092D97F');
        $this->addSql('ALTER TABLE tour_photos DROP FOREIGN KEY FK_3DF8073315ED8D43');
        $this->addSql('ALTER TABLE tour_category DROP FOREIGN KEY FK_9CB340F215ED8D43');
        $this->addSql('ALTER TABLE tour_category DROP FOREIGN KEY FK_9CB340F212469DE2');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE review_photo');
        $this->addSql('DROP TABLE tour_photos');
        $this->addSql('DROP TABLE tours');
        $this->addSql('DROP TABLE tour_category');
    }
}
