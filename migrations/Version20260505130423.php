<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260505130423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plants (id INT AUTO_INCREMENT NOT NULL, common_name VARCHAR(255) NOT NULL, scientific_name VARCHAR(255) NOT NULL, watering VARCHAR(255) NOT NULL, watering_small VARCHAR(255) NOT NULL, exposure VARCHAR(255) NOT NULL, exposure_small VARCHAR(255) NOT NULL, soil VARCHAR(255) NOT NULL, family VARCHAR(255) NOT NULL, disease VARCHAR(255) NOT NULL, repotting VARCHAR(255) NOT NULL, repotting_small VARCHAR(255) NOT NULL, humidity VARCHAR(255) NOT NULL, temperature VARCHAR(255) NOT NULL, temperature_number VARCHAR(255) NOT NULL, confidence DOUBLE PRECISION DEFAULT NULL, description LONGTEXT DEFAULT NULL, planting_period VARCHAR(100) NOT NULL, planting_distance VARCHAR(100) NOT NULL, fertilizer VARCHAR(255) NOT NULL, height VARCHAR(100) NOT NULL, width VARCHAR(100) NOT NULL, foliage VARCHAR(255) NOT NULL, foliage_type VARCHAR(255) NOT NULL, shape VARCHAR(255) NOT NULL, flowers VARCHAR(255) NOT NULL, bloom_period VARCHAR(255) NOT NULL, fruits VARCHAR(255) NOT NULL, toxicity VARCHAR(255) NOT NULL, care_tips JSON NOT NULL, is_safe_guess TINYINT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE plants');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
