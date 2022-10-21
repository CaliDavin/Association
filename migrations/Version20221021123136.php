<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021123136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_animal (user_id INT NOT NULL, animal_id INT NOT NULL, INDEX IDX_FF93822A76ED395 (user_id), INDEX IDX_FF938228E962C16 (animal_id), PRIMARY KEY(user_id, animal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_auth (user_id INT NOT NULL, auth_id INT NOT NULL, INDEX IDX_825FFC90A76ED395 (user_id), INDEX IDX_825FFC908082819C (auth_id), PRIMARY KEY(user_id, auth_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_animal ADD CONSTRAINT FK_FF93822A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_animal ADD CONSTRAINT FK_FF938228E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_auth ADD CONSTRAINT FK_825FFC90A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_auth ADD CONSTRAINT FK_825FFC908082819C FOREIGN KEY (auth_id) REFERENCES auth (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_animal DROP FOREIGN KEY FK_FF93822A76ED395');
        $this->addSql('ALTER TABLE user_animal DROP FOREIGN KEY FK_FF938228E962C16');
        $this->addSql('ALTER TABLE user_auth DROP FOREIGN KEY FK_825FFC90A76ED395');
        $this->addSql('ALTER TABLE user_auth DROP FOREIGN KEY FK_825FFC908082819C');
        $this->addSql('DROP TABLE user_animal');
        $this->addSql('DROP TABLE user_auth');
    }
}
