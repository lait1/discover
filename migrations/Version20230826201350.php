<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230826201350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` CHANGE reservation_date reservation_date INT UNSIGNED NOT NULL, CHANGE count_people count_people INT UNSIGNED NOT NULL, CHANGE created_at created_at INT UNSIGNED NOT NULL, CHANGE description comment LONGTEXT DEFAULT NULL, CHANGE confirmed confirmed_tour TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` CHANGE reservation_date reservation_date INT UNSIGNED DEFAULT NULL, CHANGE count_people count_people INT UNSIGNED DEFAULT NULL, CHANGE created_at created_at INT UNSIGNED DEFAULT NULL, CHANGE comment description LONGTEXT DEFAULT NULL, CHANGE confirmed_tour confirmed TINYINT(1) NOT NULL');
    }
}
