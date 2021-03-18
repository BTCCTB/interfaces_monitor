<?php

declare (strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411135950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Master data for roles, groups';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO `role` (`id`, `friendly_name`, `technical_name`) VALUES (1, \'User\', \'ROLE_USER\'), (2, \'Admin\', \'ROLE_ADMIN\');');
        $this->addSql('INSERT INTO `group` (`id`, `name`) VALUES (1, \'Default\'), (2, \'Admin\');');
        $this->addSql('INSERT INTO `group_role` (`group_id`, `role_id`) VALUES (\'1\', \'1\');');
        $this->addSql('INSERT INTO `group_role` (`group_id`, `role_id`) VALUES (\'2\', \'1\'), (\'2\', \'2\');');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
