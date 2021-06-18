<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210618190940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, person_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, start DATETIME NOT NULL, finish DATETIME NOT NULL, quantity INT NOT NULL, INDEX IDX_E00CEDDE64D218E (location_id), INDEX IDX_E00CEDDE217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_5E9E89CB217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, location_id INT NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(10) NOT NULL, INDEX IDX_6117D13B217BBB47 (person_id), INDEX IDX_6117D13B64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, location_id INT NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(10) NOT NULL, INDEX IDX_527EDB25217BBB47 (person_id), INDEX IDX_527EDB2564D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(20) NOT NULL, lastname VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE217BBB47 FOREIGN KEY (person_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB217BBB47 FOREIGN KEY (person_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B217BBB47 FOREIGN KEY (person_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25217BBB47 FOREIGN KEY (person_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2564D218E FOREIGN KEY (location_id) REFERENCES location (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE64D218E');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B64D218E');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2564D218E');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE217BBB47');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB217BBB47');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B217BBB47');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25217BBB47');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE `user`');
    }
}
