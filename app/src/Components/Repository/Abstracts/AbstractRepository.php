<?php


namespace App\Components\Repository\Abstracts;


use App\Components\Db\Interfaces\ConnectionInterface;

class AbstractRepository
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * AbstractRepository constructor.
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

}