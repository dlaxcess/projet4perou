<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181229181128 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, discount_id INT DEFAULT NULL, ticket_order_id INT DEFAULT NULL, visitor_first_name VARCHAR(255) DEFAULT NULL, visitor_name VARCHAR(255) NOT NULL, visitor_birth_date DATETIME NOT NULL, ticket_price INT DEFAULT NULL, booked TINYINT(1) NOT NULL, INDEX IDX_97A0ADA34C7C611F (discount_id), INDEX IDX_97A0ADA38F691B9 (ticket_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_order (id INT AUTO_INCREMENT NOT NULL, duration_id INT NOT NULL, order_date DATETIME NOT NULL, booking_code VARCHAR(255) DEFAULT NULL, visit_date DATETIME NOT NULL, booking_email VARCHAR(255) NOT NULL, ticket_amount INT DEFAULT NULL, total_price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_DD19F01337B987D8 (duration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discounts (id INT AUTO_INCREMENT NOT NULL, discount_name VARCHAR(100) NOT NULL, discount_description VARCHAR(255) DEFAULT NULL, discount_value DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ages_prices (id INT AUTO_INCREMENT NOT NULL, min_age INT NOT NULL, ticket_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE duration (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA34C7C611F FOREIGN KEY (discount_id) REFERENCES discounts (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA38F691B9 FOREIGN KEY (ticket_order_id) REFERENCES ticket_order (id)');
        $this->addSql('ALTER TABLE ticket_order ADD CONSTRAINT FK_DD19F01337B987D8 FOREIGN KEY (duration_id) REFERENCES duration (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA38F691B9');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA34C7C611F');
        $this->addSql('ALTER TABLE ticket_order DROP FOREIGN KEY FK_DD19F01337B987D8');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_order');
        $this->addSql('DROP TABLE discounts');
        $this->addSql('DROP TABLE ages_prices');
        $this->addSql('DROP TABLE duration');
    }
}
