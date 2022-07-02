<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220702061248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE authorbook ADD author_id INT DEFAULT NULL, ADD book_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE authorbook ADD CONSTRAINT FK_67C96E47F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE authorbook ADD CONSTRAINT FK_67C96E4716A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_67C96E47F675F31B ON authorbook (author_id)');
        $this->addSql('CREATE INDEX IDX_67C96E4716A2B381 ON authorbook (book_id)');
        $this->addSql('ALTER TABLE book ADD cart_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL, ADD publisher_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3311AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33140C86FCE FOREIGN KEY (publisher_id) REFERENCES publisher (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3311AD5CDBF ON book (cart_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33112469DE2 ON book (category_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33140C86FCE ON book (publisher_id)');
        $this->addSql('ALTER TABLE feedback ADD book_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D229445816A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_D229445816A2B381 ON feedback (book_id)');
        $this->addSql('ALTER TABLE orderdetails ADD book_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orderdetails ADD CONSTRAINT FK_489AFCDC16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_489AFCDC16A2B381 ON orderdetails (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE authorbook DROP FOREIGN KEY FK_67C96E47F675F31B');
        $this->addSql('ALTER TABLE authorbook DROP FOREIGN KEY FK_67C96E4716A2B381');
        $this->addSql('DROP INDEX IDX_67C96E47F675F31B ON authorbook');
        $this->addSql('DROP INDEX IDX_67C96E4716A2B381 ON authorbook');
        $this->addSql('ALTER TABLE authorbook DROP author_id, DROP book_id');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3311AD5CDBF');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33112469DE2');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33140C86FCE');
        $this->addSql('DROP INDEX IDX_CBE5A3311AD5CDBF ON book');
        $this->addSql('DROP INDEX IDX_CBE5A33112469DE2 ON book');
        $this->addSql('DROP INDEX IDX_CBE5A33140C86FCE ON book');
        $this->addSql('ALTER TABLE book DROP cart_id, DROP category_id, DROP publisher_id');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D229445816A2B381');
        $this->addSql('DROP INDEX IDX_D229445816A2B381 ON feedback');
        $this->addSql('ALTER TABLE feedback DROP book_id');
        $this->addSql('ALTER TABLE orderdetails DROP FOREIGN KEY FK_489AFCDC16A2B381');
        $this->addSql('DROP INDEX IDX_489AFCDC16A2B381 ON orderdetails');
        $this->addSql('ALTER TABLE orderdetails DROP book_id');
    }
}
