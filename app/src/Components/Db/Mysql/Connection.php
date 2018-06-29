<?php


namespace App\Components\Db\Mysql;


use App\Components\Db\Abstracts\AbstractConnection;
use App\Components\Db\Exceptions\DbException;
use App\Components\Db\Mysql\Interfaces\MysqlConnectionInterface;
use PDO;

class Connection extends AbstractConnection implements MysqlConnectionInterface
{
    /**
     * @var string
     */
    private $_user;

    /**
     * @var string
     */
    private $_password;

    /**
     * @var string
     */
    private $_db;

    /**
     * @var \PDO
     */
    private $_pdo;

    /**
     * Connection constructor.
     * @param array $config
     * @throws DbException
     */
    public function __construct(array $config)
    {
        try {
            $this->parseConfig($config);
        } catch (\Exception $exception) {
            throw new DbException('Error on config parsing', 0, $exception);
        }
    }

    /**
     * @param array $config
     */
    protected function parseConfig(array $config): void
    {
        $this->setPassword($config['password']);
        $this->setUser($config['user']);
        $this->setPort($config['port']);
        $this->setHost($config['host']);
        $this->setDb($config['db']);
    }

    /**
     * Open pdo connection
     */
    public function open()
    {
        if($this->_pdo == null){
            $this->_pdo = new PDO('mysql:host=' . $this->getHost() . ';dbname=' . $this->getDb().';charset=utf8', $this->getUser(), $this->getPassword());
        }
    }

    /**
     * Close pdo connection
     */
    public function close()
    {
        $this->_pdo = null;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->_user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->_user = $user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->_password = $password;
    }

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->_pdo;
    }

    /**
     * @return string
     */
    public function getDb(): string
    {
        return $this->_db;
    }

    /**
     * @param string $db
     */
    public function setDb(string $db): void
    {
        $this->_db = $db;
    }


}