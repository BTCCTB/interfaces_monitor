<?php

declare (strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411135910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Basic schema with users, roles, groups';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, friendly_name VARCHAR(255) NOT NULL, technical_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_role (group_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_7E33D11AFE54D947 (group_id), INDEX IDX_7E33D11AD60322AC (role_id), PRIMARY KEY(group_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, employee_number INT NOT NULL, display_name VARCHAR(255) NOT NULL, language VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_8F02BF9DA76ED395 (user_id), INDEX IDX_8F02BF9DFE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE group_role ADD CONSTRAINT FK_7E33D11AFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_role ADD CONSTRAINT FK_7E33D11AD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9DFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE group_role DROP FOREIGN KEY FK_7E33D11AD60322AC');
        $this->addSql('ALTER TABLE group_role DROP FOREIGN KEY FK_7E33D11AFE54D947');
        $this->addSql('ALTER TABLE user_group DROP FOREIGN KEY FK_8F02BF9DFE54D947');
        $this->addSql('ALTER TABLE user_group DROP FOREIGN KEY FK_8F02BF9DA76ED395');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_role');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_group');
    }
}
