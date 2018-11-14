<?php

namespace IVIR3zaM\OrganizationRelationships\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181113171117 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX organization_name_idx (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization_relation (id INT AUTO_INCREMENT NOT NULL, parent_organization_id INT DEFAULT NULL, child_organization_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_8D9185EBA504A722 (parent_organization_id), INDEX IDX_8D9185EB654C0F3 (child_organization_id), UNIQUE INDEX organization_relation_idx (parent_organization_id, child_organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organization_relation ADD CONSTRAINT FK_8D9185EBA504A722 FOREIGN KEY (parent_organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE organization_relation ADD CONSTRAINT FK_8D9185EB654C0F3 FOREIGN KEY (child_organization_id) REFERENCES organization (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organization_relation DROP FOREIGN KEY FK_8D9185EBA504A722');
        $this->addSql('ALTER TABLE organization_relation DROP FOREIGN KEY FK_8D9185EB654C0F3');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE organization_relation');
    }
}
