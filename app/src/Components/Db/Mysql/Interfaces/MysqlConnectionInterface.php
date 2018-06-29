<?php

namespace App\Components\Db\Mysql\Interfaces;

use App\Components\Db\Interfaces\ConnectionInterface;

/**
 * Interface MysqlConnectionInterface
 */
interface MysqlConnectionInterface extends ConnectionInterface
{
    /**
     * @return string
     */
    public function getUser(): string;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return string
     */
    public function getDb(): string;

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO;
}