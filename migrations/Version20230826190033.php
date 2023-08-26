<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230826190033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, tour_id INT UNSIGNED DEFAULT NULL, reservation_date INT UNSIGNED NOT NULL, count_people INT UNSIGNED NOT NULL, description LONGTEXT DEFAULT NULL, confirmed TINYINT(1) NOT NULL, created_at INT UNSIGNED NOT NULL, updated_at INT UNSIGNED DEFAULT NULL, INDEX IDX_F529939819EB6921 (client_id), INDEX IDX_F529939815ED8D43 (tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939815ED8D43 FOREIGN KEY (tour_id) REFERENCES tours (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939819EB6921');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939815ED8D43');
        $this->addSql('DROP TABLE `order`');
    }
}
