<?php

namespace App\Components\Vk;

use App\Components\Vk\Abstracts\AbstractClient;

class Client extends AbstractClient
{
    /**
     * @param string $ownerId
     * @return mixed
     * @throws \VK\Exceptions\VKApiException
     * @throws \VK\Exceptions\VKClientException
     */
    public function getAlbums(string $ownerId): array
    {
        return $this->getApi()->photos()->getAlbums($this->getServiceKey(),[
            'owner_id' => $ownerId
        ]);
    }

    /**
     * @param string $albumId
     * @param $ownerId
     * @return array
     * @throws \VK\Exceptions\VKApiException
     * @throws \VK\Exceptions\VKClientException
     */
    public function getPhotos(string $albumId,$ownerId): array
    {
        return $this->getApi()->photos()->get($this->getServiceKey(),[
            'owner_id' => $ownerId,
            'album_id' => $albumId
        ]);
    }
}