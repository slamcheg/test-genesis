<?php


namespace App\Components\Vk\Abstracts;


use App\Components\Vk\Interfaces\ClientInterface;
use App\Components\Vk\Traits\ApiAwareTrait;

abstract class AbstractClient implements ClientInterface
{
    use ApiAwareTrait;

    /**
     * @var string
     */
    private $_serviceKey;

    /**
     * Client constructor.
     * @param $_serviceKey
     */
    public function __construct(string $_serviceKey)
    {
        $this->_serviceKey = $_serviceKey;
    }

    /**
     * @return string
     */
    public function getServiceKey(): string
    {
        return $this->_serviceKey;
    }

}