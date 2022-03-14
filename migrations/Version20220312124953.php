<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220312124953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE id_number (id INT AUTO_INCREMENT NOT NULL, phone_id INT DEFAULT NULL, imei VARCHAR(13) NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_B0A7AAB93B7323CB (phone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phone_model (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(30) NOT NULL, model VARCHAR(30) NOT NULL, year VARCHAR(4) DEFAULT NULL, description LONGTEXT DEFAULT NULL, stock_limit INT NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE id_number ADD CONSTRAINT FK_B0A7AAB93B7323CB FOREIGN KEY (phone_id) REFERENCES phone_model (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE id_number DROP FOREIGN KEY FK_B0A7AAB93B7323CB');
        $this->addSql('DROP TABLE id_number');
        $this->addSql('DROP TABLE phone_model');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
