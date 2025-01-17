<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116154933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amenity ADD CONSTRAINT FK_AB60796354B9D732 FOREIGN KEY (icon_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E53DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE annonce_amenity ADD CONSTRAINT FK_510FE3038805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_amenity ADD CONSTRAINT FK_510FE3039F9F1305 FOREIGN KEY (amenity_id) REFERENCES amenity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C13DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE image_list ADD CONSTRAINT FK_B6F212868805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849558805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amenity DROP FOREIGN KEY FK_AB60796354B9D732');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C13DA5256D');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E53DA5256D');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E512469DE2');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849558805AB2F');
        $this->addSql('ALTER TABLE image_list DROP FOREIGN KEY FK_B6F212868805AB2F');
        $this->addSql('ALTER TABLE annonce_amenity DROP FOREIGN KEY FK_510FE3038805AB2F');
        $this->addSql('ALTER TABLE annonce_amenity DROP FOREIGN KEY FK_510FE3039F9F1305');
    }
}
