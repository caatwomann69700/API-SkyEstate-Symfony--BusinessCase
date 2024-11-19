<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241115220142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE amenity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_amenity (annonce_id INT NOT NULL, amenity_id INT NOT NULL, INDEX IDX_510FE3038805AB2F (annonce_id), INDEX IDX_510FE3039F9F1305 (amenity_id), PRIMARY KEY(annonce_id, amenity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce_amenity ADD CONSTRAINT FK_510FE3038805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_amenity ADD CONSTRAINT FK_510FE3039F9F1305 FOREIGN KEY (amenity_id) REFERENCES amenity (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce_amenity DROP FOREIGN KEY FK_510FE3038805AB2F');
        $this->addSql('ALTER TABLE annonce_amenity DROP FOREIGN KEY FK_510FE3039F9F1305');
        $this->addSql('DROP TABLE amenity');
        $this->addSql('DROP TABLE annonce_amenity');
    }
}
