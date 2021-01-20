<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210120113450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5A726995');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('DROP INDEX IDX_9474526C9D86650F ON comment');
        $this->addSql('DROP INDEX IDX_9474526C5A726995 ON comment');
        $this->addSql('ALTER TABLE comment ADD user_id INT NOT NULL, ADD exercise_id INT NOT NULL, DROP user_id_id, DROP exercise_id_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CE934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526CE934951A ON comment (exercise_id)');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E5A726995');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E9D86650F');
        $this->addSql('DROP INDEX IDX_FCDCEB2E9D86650F ON goal');
        $this->addSql('DROP INDEX IDX_FCDCEB2E5A726995 ON goal');
        $this->addSql('ALTER TABLE goal ADD user_id INT NOT NULL, ADD exercise_id INT NOT NULL, DROP user_id_id, DROP exercise_id_id');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2EE934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2EA76ED395 ON goal (user_id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2EE934951A ON goal (exercise_id)');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F2465A726995');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F2469D86650F');
        $this->addSql('DROP INDEX IDX_2201F2469D86650F ON progress');
        $this->addSql('DROP INDEX IDX_2201F2465A726995 ON progress');
        $this->addSql('ALTER TABLE progress ADD user_id INT NOT NULL, ADD exercise_id INT NOT NULL, DROP user_id_id, DROP exercise_id_id');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F246A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F246E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id)');
        $this->addSql('CREATE INDEX IDX_2201F246A76ED395 ON progress (user_id)');
        $this->addSql('CREATE INDEX IDX_2201F246E934951A ON progress (exercise_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CE934951A');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395 ON comment');
        $this->addSql('DROP INDEX IDX_9474526CE934951A ON comment');
        $this->addSql('ALTER TABLE comment ADD user_id_id INT NOT NULL, ADD exercise_id_id INT NOT NULL, DROP user_id, DROP exercise_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5A726995 FOREIGN KEY (exercise_id_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id_id)');
        $this->addSql('CREATE INDEX IDX_9474526C5A726995 ON comment (exercise_id_id)');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EA76ED395');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2EE934951A');
        $this->addSql('DROP INDEX IDX_FCDCEB2EA76ED395 ON goal');
        $this->addSql('DROP INDEX IDX_FCDCEB2EE934951A ON goal');
        $this->addSql('ALTER TABLE goal ADD user_id_id INT NOT NULL, ADD exercise_id_id INT NOT NULL, DROP user_id, DROP exercise_id');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E5A726995 FOREIGN KEY (exercise_id_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2E9D86650F ON goal (user_id_id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2E5A726995 ON goal (exercise_id_id)');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F246A76ED395');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F246E934951A');
        $this->addSql('DROP INDEX IDX_2201F246A76ED395 ON progress');
        $this->addSql('DROP INDEX IDX_2201F246E934951A ON progress');
        $this->addSql('ALTER TABLE progress ADD user_id_id INT NOT NULL, ADD exercise_id_id INT NOT NULL, DROP user_id, DROP exercise_id');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F2465A726995 FOREIGN KEY (exercise_id_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F2469D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2201F2469D86650F ON progress (user_id_id)');
        $this->addSql('CREATE INDEX IDX_2201F2465A726995 ON progress (exercise_id_id)');
    }
}
