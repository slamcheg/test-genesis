<?php


namespace App\Components\Db\Interfaces;


/**
 * Interface SelectableQuery
 * @package App\Components\Db\Interfaces
 */
interface SelectableQueryInterface
{
    /**
     * @param $connection
     * @param $mode
     * @return array
     */
    public function fetchAll($connection, $mode = null): array;

    /**
     * @param $connection
     * @param $mode
     * @return array
     */
    public function fetchOne($connection, $mode = null): ?array;
}