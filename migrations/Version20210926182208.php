<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210926182208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE login (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, vault_id INT NOT NULL, name VARCHAR(30) NOT NULL, website VARCHAR(100) DEFAULT NULL, username VARCHAR(30) DEFAULT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_AA08CB10A76ED395 (user_id), INDEX IDX_AA08CB1058AC2DF8 (vault_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, vault_id INT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(1020) NOT NULL, INDEX IDX_CFBDFA14A76ED395 (user_id), INDEX IDX_CFBDFA1458AC2DF8 (vault_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(25) NOT NULL, last_name VARCHAR(25) NOT NULL, username VARCHAR(25) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, registered_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vault (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, data VARCHAR(255) NOT NULL, INDEX IDX_FF304921A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE login ADD CONSTRAINT FK_AA08CB10A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE login ADD CONSTRAINT FK_AA08CB1058AC2DF8 FOREIGN KEY (vault_id) REFERENCES vault (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1458AC2DF8 FOREIGN KEY (vault_id) REFERENCES vault (id)');
        $this->addSql('ALTER TABLE vault ADD CONSTRAINT FK_FF304921A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE login DROP FOREIGN KEY FK_AA08CB10A76ED395');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A76ED395');
        $this->addSql('ALTER TABLE vault DROP FOREIGN KEY FK_FF304921A76ED395');
        $this->addSql('ALTER TABLE login DROP FOREIGN KEY FK_AA08CB1058AC2DF8');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1458AC2DF8');
        $this->addSql('DROP TABLE login');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vault');
    }
}
