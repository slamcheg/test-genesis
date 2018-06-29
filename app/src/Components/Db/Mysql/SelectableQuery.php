<?php


namespace App\Components\Db\Mysql;

use App\Components\Db\Interfaces\SelectableQueryInterface;
use App\Components\Db\Mysql\Interfaces\MysqlConnectionInterface;

class SelectableQuery implements SelectableQueryInterface
{
    /**
     * @var string
     */
    private $_query;

    /**
     * @var array
     */
    private $_bindings;

    /**
     * @var \PDOStatement
     */
    private $_stmt;

    /**
     * MysqlExecutableQuery constructor.
     * @param string $_query
     * @param array $bindings
     */
    public function __construct(string $_query, array $bindings = [])
    {
        $this->_query = $_query;
        $this->_bindings = $bindings;
    }


    /**
     * @param MysqlConnectionInterface $connection
     * @return bool
     */
    private function execute($connection): bool
    {
        $this->prepare($connection->getPdo());
        if (!empty($this->_stmt)) {
            return $this->_stmt->execute();
        }

        return false;
    }

    /**
     * @param \PDO $pdo
     */
    private function prepare(\PDO $pdo)
    {
        $this->_stmt = $pdo->prepare($this->getQuery());
        if (!empty($this->_bindings)) {
            foreach ($this->_bindings as $name => $value) {
                $this->_stmt->bindValue($name, $value);
            }
        }
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->_query;
    }

    /**
     * @param $connection
     * @param $mode
     * @return array
     */
    public function fetchAll($connection, $mode = \PDO::FETCH_ASSOC): array
    {
        if ($this->execute($connection)) {
            $result = $this->_stmt->fetchAll($mode);
            return !empty($result) ? $result : [];
        }
        return null;
    }

    /**
     * @param $connection
     * @param $mode
     * @return array
     */
    public function fetchOne($connection, $mode = \PDO::FETCH_ASSOC): ?array
    {
        if ($this->execute($connection)) {
            $result = $this->_stmt->fetch($mode);
            return !empty($result) ? $result : null;
        }
        return null;
    }
}