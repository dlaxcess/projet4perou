<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181006100807 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket ADD duration_id INT NOT NULL, DROP duration');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA337B987D8 FOREIGN KEY (duration_id) REFERENCES duration (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA337B987D8 ON ticket (duration_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA337B987D8');
        $this->addSql('DROP INDEX IDX_97A0ADA337B987D8 ON ticket');
        $this->addSql('ALTER TABLE ticket ADD duration VARCHAR(7) NOT NULL COLLATE utf8mb4_unicode_ci, DROP duration_id');
    }
}
