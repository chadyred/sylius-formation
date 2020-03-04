<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304161559 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_product ADD supplier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_product ADD CONSTRAINT FK_677B9B742ADD6D8C FOREIGN KEY (supplier_id) REFERENCES sylius_supplier (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_677B9B742ADD6D8C ON sylius_product (supplier_id)');
        $this->addSql('ALTER TABLE sylius_supplier ADD email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_product DROP FOREIGN KEY FK_677B9B742ADD6D8C');
        $this->addSql('DROP INDEX IDX_677B9B742ADD6D8C ON sylius_product');
        $this->addSql('ALTER TABLE sylius_product DROP supplier_id');
        $this->addSql('ALTER TABLE sylius_supplier DROP email');
    }
}
