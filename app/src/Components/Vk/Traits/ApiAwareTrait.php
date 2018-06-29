<?php

namespace App\Components\Vk\Traits;


use VK\Client\VKApiClient;

trait ApiAwareTrait
{
    /**
     * @var VKApiClient
     */
    private $_api;

    /**
     * @return VKApiClient
     */
    public function getApi(): VKApiClient
    {
        if($this->_api == null){
            $this->_api = new VKApiClient();
        }
        return $this->_api;
    }

    /**
     * @param VKApiClient $api
     */
    public function setApi($api)
    {
        $this->_api = $api;
    }

}