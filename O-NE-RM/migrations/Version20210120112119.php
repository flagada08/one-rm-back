<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210120112119 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64959451621');
        $this->addSql('DROP INDEX IDX_8D93D64959451621 ON user');
        $this->addSql('ALTER TABLE user CHANGE fitness_room_id_id fitness_room_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499E1CFEED FOREIGN KEY (fitness_room_id) REFERENCES fitness_room (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6499E1CFEED ON user (fitness_room_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6499E1CFEED');
        $this->addSql('DROP INDEX IDX_8D93D6499E1CFEED ON `user`');
        $this->addSql('ALTER TABLE `user` CHANGE fitness_room_id fitness_room_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64959451621 FOREIGN KEY (fitness_room_id_id) REFERENCES fitness_room (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64959451621 ON `user` (fitness_room_id_id)');
    }
}
