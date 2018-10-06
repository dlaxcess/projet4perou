<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181006092303 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` ADD booking_email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD rate_id INT NOT NULL, ADD order_id INT NOT NULL, ADD visitor_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3BC999F9F FOREIGN KEY (rate_id) REFERENCES rate (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA38D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3BC999F9F ON ticket (rate_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA38D9F6D38 ON ticket (order_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP booking_email');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3BC999F9F');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA38D9F6D38');
        $this->addSql('DROP INDEX IDX_97A0ADA3BC999F9F ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA38D9F6D38 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP rate_id, DROP order_id, DROP visitor_name');
    }
}
