<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230911093106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id SMALLINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, priority INT UNSIGNED DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, phone VARCHAR(180) NOT NULL, email VARCHAR(180) DEFAULT NULL, name VARCHAR(50) DEFAULT NULL, password VARCHAR(255) NOT NULL, created_at INT UNSIGNED NOT NULL, UNIQUE INDEX UNIQ_C7440455444F97DD (phone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_tour (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, tour_id INT UNSIGNED NOT NULL, reservation_date INT UNSIGNED NOT NULL, count_people INT UNSIGNED NOT NULL, comment LONGTEXT DEFAULT NULL, status VARCHAR(10) NOT NULL, created_at INT UNSIGNED NOT NULL, updated_at INT UNSIGNED DEFAULT NULL, INDEX IDX_2720C37E19EB6921 (client_id), INDEX IDX_2720C37E15ED8D43 (tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, tour_id INT UNSIGNED DEFAULT NULL, text LONGTEXT NOT NULL, assessment SMALLINT NOT NULL, public TINYINT(1) NOT NULL, show_main_page TINYINT(1) NOT NULL, answer VARCHAR(255) DEFAULT NULL, created_at INT UNSIGNED NOT NULL, INDEX IDX_794381C6F675F31B (author_id), INDEX IDX_794381C615ED8D43 (tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review_photo (id INT AUTO_INCREMENT NOT NULL, reviews_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_739A8038092D97F (reviews_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id SMALLINT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour_descriptions (id INT UNSIGNED AUTO_INCREMENT NOT NULL, tour_id INT UNSIGNED DEFAULT NULL, header VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_CB636BEE15ED8D43 (tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour_options (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour_photos (id INT UNSIGNED AUTO_INCREMENT NOT NULL, tour_id INT UNSIGNED DEFAULT NULL, path VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, priority INT NOT NULL, INDEX IDX_3DF8073315ED8D43 (tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tours (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, main_image VARCHAR(255) DEFAULT NULL, price INT UNSIGNED DEFAULT 0, long_time VARCHAR(255) DEFAULT NULL, complexity VARCHAR(255) DEFAULT NULL, group_size INT UNSIGNED DEFAULT NULL, details JSON DEFAULT NULL, key_words VARCHAR(255) DEFAULT NULL, youtube_link VARCHAR(255) DEFAULT NULL, created_at INT UNSIGNED NOT NULL, public TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour_category (tour_id INT UNSIGNED NOT NULL, category_id SMALLINT NOT NULL, INDEX IDX_9CB340F215ED8D43 (tour_id), INDEX IDX_9CB340F212469DE2 (category_id), PRIMARY KEY(tour_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, telegram_token VARCHAR(180) DEFAULT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id SMALLINT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_tour ADD CONSTRAINT FK_2720C37E19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE order_tour ADD CONSTRAINT FK_2720C37E15ED8D43 FOREIGN KEY (tour_id) REFERENCES tours (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6F675F31B FOREIGN KEY (author_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C615ED8D43 FOREIGN KEY (tour_id) REFERENCES tours (id)');
        $this->addSql('ALTER TABLE review_photo ADD CONSTRAINT FK_739A8038092D97F FOREIGN KEY (reviews_id) REFERENCES review (id)');
        $this->addSql('ALTER TABLE tour_descriptions ADD CONSTRAINT FK_CB636BEE15ED8D43 FOREIGN KEY (tour_id) REFERENCES tours (id)');
        $this->addSql('ALTER TABLE tour_photos ADD CONSTRAINT FK_3DF8073315ED8D43 FOREIGN KEY (tour_id) REFERENCES tours (id)');
        $this->addSql('ALTER TABLE tour_category ADD CONSTRAINT FK_9CB340F215ED8D43 FOREIGN KEY (tour_id) REFERENCES tours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tour_category ADD CONSTRAINT FK_9CB340F212469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_tour DROP FOREIGN KEY FK_2720C37E19EB6921');
        $this->addSql('ALTER TABLE order_tour DROP FOREIGN KEY FK_2720C37E15ED8D43');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6F675F31B');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C615ED8D43');
        $this->addSql('ALTER TABLE review_photo DROP FOREIGN KEY FK_739A8038092D97F');
        $this->addSql('ALTER TABLE tour_descriptions DROP FOREIGN KEY FK_CB636BEE15ED8D43');
        $this->addSql('ALTER TABLE tour_photos DROP FOREIGN KEY FK_3DF8073315ED8D43');
        $this->addSql('ALTER TABLE tour_category DROP FOREIGN KEY FK_9CB340F215ED8D43');
        $this->addSql('ALTER TABLE tour_category DROP FOREIGN KEY FK_9CB340F212469DE2');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE order_tour');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE review_photo');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE tour_descriptions');
        $this->addSql('DROP TABLE tour_options');
        $this->addSql('DROP TABLE tour_photos');
        $this->addSql('DROP TABLE tours');
        $this->addSql('DROP TABLE tour_category');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
