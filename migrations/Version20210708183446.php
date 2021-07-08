<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708183446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE balance (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, amount INT(11) NOT NULL, currency VARCHAR(3) NOT NULL, UNIQUE INDEX UNIQ_ACF41FFEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, balance_from_id INT NOT NULL, balance_to_id INT NOT NULL, amount INT(11) NOT NULL, currency VARCHAR(3) NOT NULL, created_at INT NOT NULL, UNIQUE INDEX UNIQ_723705D14C25FBB1 (balance_from_id), UNIQUE INDEX UNIQ_723705D1AE43FB37 (balance_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE balance ADD CONSTRAINT FK_ACF41FFEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14C25FBB1 FOREIGN KEY (balance_from_id) REFERENCES balance (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1AE43FB37 FOREIGN KEY (balance_to_id) REFERENCES balance (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D14C25FBB1');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1AE43FB37');
        $this->addSql('ALTER TABLE balance DROP FOREIGN KEY FK_ACF41FFEA76ED395');
        $this->addSql('DROP TABLE balance');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
    }
}
