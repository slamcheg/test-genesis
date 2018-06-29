<?php


namespace App\Migrations;


use App\Components\Db\Interfaces\ExecutableQueryInterface;
use App\Components\Db\Mysql\ExecutableQuery;
use App\Components\DbMigration\Abstracts\AbstractMigration;

class CreateUserTable extends AbstractMigration
{

    /**
     * @return ExecutableQueryInterface
     */
    public function up(): ExecutableQueryInterface
    {
        return new ExecutableQuery(' CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, owner_id VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB');
    }

    /**
     * @return ExecutableQueryInterface
     */
    public function down(): ExecutableQueryInterface
    {
        return new ExecutableQuery('DROP TABLE user');
    }
}