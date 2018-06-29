<?php


namespace App\Components\Db\Interfaces;

/**
 * Interface QueryBuilder
 * @package App\Components\Db\Interfaces
 */
interface QueryBuilderInterface
{
    /**
     * @param string $query
     * @param array $bindings
     * @return SelectableQueryInterface
     */
    public function select(string $query, array $bindings): SelectableQueryInterface;

    /**
     * @param string $query
     * @param array $bindings
     * @return ExecutableQueryInterface
     */
    public function insert(string $query, array $bindings): ExecutableQueryInterface;


}