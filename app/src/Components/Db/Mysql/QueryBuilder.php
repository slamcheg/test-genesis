<?php


namespace App\Components\Db\Mysql;


use App\Components\Db\Interfaces\ExecutableQueryInterface;
use App\Components\Db\Interfaces\QueryBuilderInterface;
use App\Components\Db\Interfaces\SelectableQueryInterface;

/**
 * Class QueryBuilder
 * @package App\Components\Db\Mysql
 */
class QueryBuilder implements QueryBuilderInterface
{
    /**
     * @param string $query
     * @param array $bindings
     * @return SelectableQueryInterface
     */
    public function select(string $query, array $bindings = []): SelectableQueryInterface
    {
        return new SelectableQuery($query, $bindings);
    }

    /**
     * @param string $query
     * @param array $bindings
     * @return ExecutableQueryInterface
     */
    public function insert(string $query, array $bindings = []): ExecutableQueryInterface
    {
        return new ExecutableQuery($query, $bindings);
    }
}