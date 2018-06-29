<?php


namespace App\Components\DbMigration\Mysql;


use App\Components\Db\Interfaces\ExecutableQueryInterface;
use App\Components\Db\Mysql\ExecutableQuery;
use App\Components\Db\Mysql\Interfaces\MysqlConnectionInterface;
use App\Components\Db\Mysql\QueryBuilder;
use App\Components\DbMigration\Abstracts\AbstractExecutor;
use App\Components\DbMigration\Interfaces\MigrationInterface;

class Executor extends AbstractExecutor
{
    /**
     * @var MysqlConnectionInterface
     */
    private $_connection;

    /**
     * @var ExecutableQueryInterface[]
     */
    private $_migrations;

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * Migration constructor.
     * @param MysqlConnectionInterface $connection
     * @param array $migrations
     */
    public function __construct(MysqlConnectionInterface $connection, array $migrations)
    {
        $this->queryBuilder = new QueryBuilder();
        $this->_migrations = $migrations;
        $this->_connection = $connection;
    }
    public function upMigrations(): void
    {
        if (!empty($this->_migrations)) {
            /** @var MigrationInterface $migration */
            foreach ($this->_migrations as $migration) {
                $migration->up()->execute($this->_connection);
            }
        }
    }

    public function downMigrations(): void
    {
        if (!empty($this->_migrations)) {
            (new ExecutableQuery("SET foreign_key_checks = 0;"))->execute($this->_connection);
            /** @var MigrationInterface $migration */
            foreach ($this->_migrations as $migration) {
                $migration->down()->execute($this->_connection);
            }
            (new ExecutableQuery("SET foreign_key_checks = 1;"))->execute($this->_connection);

        }
    }
}