<?php


namespace App\Components\Db\Interfaces;

/**
 * Interface ExecutableQuery
 * @package App\Components\Db\Interfaces
 */
interface ExecutableQueryInterface
{
    /**
     * @param ConnectionInterface $connection
     * @return bool
     */
    public function execute($connection): bool;
}