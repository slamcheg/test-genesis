<?php


namespace App\Components\Db\Interfaces;

/**
 * Interface ConnectionInterface
 * @package App\Components\Db\Interfaces
 */
interface ConnectionInterface
{
    /**
     * @return string
     */
    public function getHost(): string;

    /**
     * @return string
     */
    public function getPort(): string;
}