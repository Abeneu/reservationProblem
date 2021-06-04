<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210604134857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_chambre DROP FOREIGN KEY FK_A29C5F7AB83297E7');
        $this->addSql('ALTER TABLE reservation_chambre ADD CONSTRAINT FK_A29C5F7AB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_chambre DROP FOREIGN KEY FK_A29C5F7AB83297E7');
        $this->addSql('ALTER TABLE reservation_chambre ADD CONSTRAINT FK_A29C5F7AB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
