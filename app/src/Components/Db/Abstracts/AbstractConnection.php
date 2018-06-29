<?php


namespace App\Components\Db\Abstracts;


use App\Components\Db\Interfaces\ConnectionInterface;

abstract class AbstractConnection implements ConnectionInterface
{
    /**
     * @var string
     */
    private $_host;

    /**
     * @var string
     */
    private $_port;

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->_host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->_host = $host;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->_port;
    }

    /**
     * @param string $port
     */
    public function setPort(string $port): void
    {
        $this->_port = $port;
    }

    /**
     * @param array $config
     */
    abstract protected function parseConfig(array $config): void;


}