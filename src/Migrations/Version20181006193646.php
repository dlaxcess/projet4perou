<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181006193646 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ticket_order (id INT AUTO_INCREMENT NOT NULL, order_date DATETIME NOT NULL, booking_code VARCHAR(255) NOT NULL, booking_email VARCHAR(255) NOT NULL, total_price DOUBLE PRECISION NOT NULL, ticket_amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket ADD duration_id INT NOT NULL, ADD rate_id INT NOT NULL, ADD ticket_order_id INT DEFAULT NULL, ADD visitor_name VARCHAR(255) NOT NULL, DROP duration, CHANGE date visit_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA337B987D8 FOREIGN KEY (duration_id) REFERENCES duration (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3BC999F9F FOREIGN KEY (rate_id) REFERENCES rate (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA38F691B9 FOREIGN KEY (ticket_order_id) REFERENCES ticket_order (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA337B987D8 ON ticket (duration_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3BC999F9F ON ticket (rate_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA38F691B9 ON ticket (ticket_order_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA38F691B9');
        $this->addSql('DROP TABLE ticket_order');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA337B987D8');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3BC999F9F');
        $this->addSql('DROP INDEX IDX_97A0ADA337B987D8 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3BC999F9F ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA38F691B9 ON ticket');
        $this->addSql('ALTER TABLE ticket ADD duration VARCHAR(7) NOT NULL COLLATE utf8mb4_unicode_ci, DROP duration_id, DROP rate_id, DROP ticket_order_id, DROP visitor_name, CHANGE visit_date date DATETIME NOT NULL');
    }
}
