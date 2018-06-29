<?php

namespace App\Components\Vk\Interfaces;

use VK\Client\VKApiClient;

interface ClientInterface
{
    public function getApi(): VKApiClient;

    public function getServiceKey(): string;
}