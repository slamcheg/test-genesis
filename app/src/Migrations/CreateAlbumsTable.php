<?php


namespace App\Migrations;



use App\Components\Db\Interfaces\ExecutableQueryInterface;
use App\Components\Db\Mysql\ExecutableQuery;
use App\Components\DbMigration\Abstracts\AbstractMigration;

class CreateAlbumsTable extends AbstractMigration
{
    /**
     * @return ExecutableQueryInterface
     */
    public function up(): ExecutableQueryInterface
    {
        return new ExecutableQuery('CREATE TABLE album (
                        id INT AUTO_INCREMENT NOT NULL,
                        title VARCHAR(255) DEFAULT NULL,
                        unique_id VARCHAR(255) NOT NULL,
                        user_id INT NOT NULL,
                        created_at INT NOT NULL,
                        updated_at INT NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY (user_id)
                            REFERENCES user (id)
                            ON DELETE CASCADE
                        
                    )DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB'
        );
    }

    /**
     * @return ExecutableQueryInterface
     */
    public function down(): ExecutableQueryInterface
    {
        return new ExecutableQuery('DROP TABLE album');
    }
}