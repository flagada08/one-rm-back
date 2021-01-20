<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210120110728 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD user_id_id INT NOT NULL, ADD exercise_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5A726995 FOREIGN KEY (exercise_id_id) REFERENCES exercise (id)');
        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id_id)');
        $this->addSql('CREATE INDEX IDX_9474526C5A726995 ON comment (exercise_id_id)');
        $this->addSql('ALTER TABLE goal ADD user_id_id INT NOT NULL, ADD exercise_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E5A726995 FOREIGN KEY (exercise_id_id) REFERENCES exercise (id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2E9D86650F ON goal (user_id_id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2E5A726995 ON goal (exercise_id_id)');
        $this->addSql('ALTER TABLE progress ADD user_id_id INT NOT NULL, ADD exercise_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F2469D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F2465A726995 FOREIGN KEY (exercise_id_id) REFERENCES exercise (id)');
        $this->addSql('CREATE INDEX IDX_2201F2469D86650F ON progress (user_id_id)');
        $this->addSql('CREATE INDEX IDX_2201F2465A726995 ON progress (exercise_id_id)');
        $this->addSql('ALTER TABLE user ADD fitness_room_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64959451621 FOREIGN KEY (fitness_room_id_id) REFERENCES fitness_room (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64959451621 ON user (fitness_room_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5A726995');
        $this->addSql('DROP INDEX IDX_9474526C9D86650F ON comment');
        $this->addSql('DROP INDEX IDX_9474526C5A726995 ON comment');
        $this->addSql('ALTER TABLE comment DROP user_id_id, DROP exercise_id_id');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E9D86650F');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E5A726995');
        $this->addSql('DROP INDEX IDX_FCDCEB2E9D86650F ON goal');
        $this->addSql('DROP INDEX IDX_FCDCEB2E5A726995 ON goal');
        $this->addSql('ALTER TABLE goal DROP user_id_id, DROP exercise_id_id');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F2469D86650F');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F2465A726995');
        $this->addSql('DROP INDEX IDX_2201F2469D86650F ON progress');
        $this->addSql('DROP INDEX IDX_2201F2465A726995 ON progress');
        $this->addSql('ALTER TABLE progress DROP user_id_id, DROP exercise_id_id');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64959451621');
        $this->addSql('DROP INDEX IDX_8D93D64959451621 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP fitness_room_id_id');
    }
}
