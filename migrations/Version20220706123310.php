<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706123310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger DROP quantite');
        $this->addSql('ALTER TABLE menu_boisson DROP FOREIGN KEY FK_34CD5F3734B8089');
        $this->addSql('ALTER TABLE menu_boisson DROP FOREIGN KEY FK_34CD5F3CCD7E912');
        $this->addSql('ALTER TABLE menu_boisson ADD id INT AUTO_INCREMENT NOT NULL, ADD quantite_boisson INT NOT NULL, CHANGE menu_id menu_id INT DEFAULT NULL, CHANGE boisson_id boisson_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D517CE5090');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D5CCD7E912');
        $this->addSql('ALTER TABLE menu_burger ADD id INT AUTO_INCREMENT NOT NULL, ADD quantite_burger INT NOT NULL, CHANGE menu_id menu_id INT DEFAULT NULL, CHANGE burger_id burger_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_frite DROP FOREIGN KEY FK_B147E70ABE00B4D9');
        $this->addSql('ALTER TABLE menu_frite DROP FOREIGN KEY FK_B147E70ACCD7E912');
        $this->addSql('ALTER TABLE menu_frite ADD id INT AUTO_INCREMENT NOT NULL, ADD quantite_frite INT NOT NULL, CHANGE frite_id frite_id INT DEFAULT NULL, CHANGE menu_id menu_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE menu_frite ADD CONSTRAINT FK_B147E70ABE00B4D9 FOREIGN KEY (frite_id) REFERENCES frite (id)');
        $this->addSql('ALTER TABLE menu_frite ADD CONSTRAINT FK_B147E70ACCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger ADD quantite INT NOT NULL');
        $this->addSql('ALTER TABLE menu_boisson MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_boisson DROP FOREIGN KEY FK_34CD5F3CCD7E912');
        $this->addSql('ALTER TABLE menu_boisson DROP FOREIGN KEY FK_34CD5F3734B8089');
        $this->addSql('ALTER TABLE menu_boisson DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE menu_boisson DROP id, DROP quantite_boisson, CHANGE menu_id menu_id INT NOT NULL, CHANGE boisson_id boisson_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_boisson ADD PRIMARY KEY (menu_id, boisson_id)');
        $this->addSql('ALTER TABLE menu_burger MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D517CE5090');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D5CCD7E912');
        $this->addSql('ALTER TABLE menu_burger DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE menu_burger DROP id, DROP quantite_burger, CHANGE burger_id burger_id INT NOT NULL, CHANGE menu_id menu_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_burger ADD PRIMARY KEY (menu_id, burger_id)');
        $this->addSql('ALTER TABLE menu_frite MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_frite DROP FOREIGN KEY FK_B147E70ACCD7E912');
        $this->addSql('ALTER TABLE menu_frite DROP FOREIGN KEY FK_B147E70ABE00B4D9');
        $this->addSql('ALTER TABLE menu_frite DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE menu_frite DROP id, DROP quantite_frite, CHANGE menu_id menu_id INT NOT NULL, CHANGE frite_id frite_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_frite ADD CONSTRAINT FK_B147E70ACCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_frite ADD CONSTRAINT FK_B147E70ABE00B4D9 FOREIGN KEY (frite_id) REFERENCES frite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_frite ADD PRIMARY KEY (menu_id, frite_id)');
    }
}
