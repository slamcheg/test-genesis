<?php


namespace App\Migrations;


use App\Components\Db\Interfaces\ExecutableQueryInterface;
use App\Components\Db\Mysql\ExecutableQuery;
use App\Components\DbMigration\Abstracts\AbstractMigration;

class CreatePhotoTable extends AbstractMigration
{

    /**
     * @return ExecutableQueryInterface
     */
    public function up(): ExecutableQueryInterface
    {
        return new ExecutableQuery('CREATE TABLE photo (
                        id INT AUTO_INCREMENT NOT NULL,
                        album_id INT NOT NULL,
                        unique_id VARCHAR(255) NOT NULL,                        
                        url VARCHAR (255) NOT NULL,
                        date INT NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY (album_id)
                            REFERENCES album (id)
                            ON DELETE CASCADE
                        
                    )DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB'
        );
    }

    /**
     * @return ExecutableQueryInterface
     */
    public function down(): ExecutableQueryInterface
    {
        return new ExecutableQuery('DROP TABLE photo');
    }
}