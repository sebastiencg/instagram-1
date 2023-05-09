<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505135432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE relationships (id INT AUTO_INCREMENT NOT NULL, freind_id INT DEFAULT NULL, user INT NOT NULL, INDEX IDX_CDF868A7DA36F2E7 (freind_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE relationships ADD CONSTRAINT FK_CDF868A7DA36F2E7 FOREIGN KEY (freind_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE relationships DROP FOREIGN KEY FK_CDF868A7DA36F2E7');
        $this->addSql('DROP TABLE relationships');
    }
}
