<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230922113017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_date (reservation_date VARCHAR(255) NOT NULL, order_tour_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at INT UNSIGNED NOT NULL, INDEX IDX_BCA7FA12E3972408 (order_tour_id), INDEX IDX_BCA7FA12A76ED395 (user_id), PRIMARY KEY(reservation_date)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_date ADD CONSTRAINT FK_BCA7FA12E3972408 FOREIGN KEY (order_tour_id) REFERENCES order_tour (id)');
        $this->addSql('ALTER TABLE reservation_date ADD CONSTRAINT FK_BCA7FA12A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_tour DROP reservation_date');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_date DROP FOREIGN KEY FK_BCA7FA12E3972408');
        $this->addSql('ALTER TABLE reservation_date DROP FOREIGN KEY FK_BCA7FA12A76ED395');
        $this->addSql('DROP TABLE reservation_date');
        $this->addSql('ALTER TABLE order_tour ADD reservation_date INT NOT NULL');
    }
}
