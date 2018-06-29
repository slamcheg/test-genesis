<?php


namespace App\Components\Parser;


use App\Components\Db\Interfaces\ConnectionInterface;
use App\Components\Db\Mysql\Interfaces\MysqlConnectionInterface;
use App\Components\Vk\Client;
use App\Repositories\AlbumRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\UserRepository;

/**
 * Class Parser
 * @package App\Components\Parser
 */
class Parser
{
    /**
     * @var MysqlConnectionInterface
     */
    private $_connection;

    /**
     * @var Client
     */
    private $_api;

    /**
     * Parser constructor.
     * @param string $vkServiceKey
     * @param MysqlConnectionInterface $connection
     */
    public function __construct(string $vkServiceKey, MysqlConnectionInterface $connection)
    {
        $this->_connection = $connection;
        $this->_api = new Client($vkServiceKey);
    }

    /**
     * @param string $ownerId
     * @throws \Exception
     */
    public function parseSingleUser(string $ownerId): void
    {
        $this->getConnection()->getPdo()->beginTransaction();
        try {
            $user = $this->getUser($ownerId);
            $this->createAlbumForUser($user);
            $this->getConnection()->getPdo()->commit();
        } catch (\Exception $exception) {
            $this->getConnection()->getPdo()->rollBack();
            var_dump($exception->getMessage());
            die();
        }

    }

    /**
     * @param string $owner
     * @return array|null
     */
    private function getUser(string $owner): ?array
    {
        $repository = new UserRepository($this->getConnection());
        $ownerEntity = $repository->findByOwnerId($owner);
        if (empty($ownerEntity)) {
            $repository->createUser($owner);
        }
        return !empty($ownerEntity) ? $ownerEntity : $repository->findByOwnerId($owner);
    }

    /**
     * @param string $uniqueId
     * @return array|null
     */
    private function getAlbum(string $uniqueId): ?array
    {
        return (new AlbumRepository($this->getConnection()))->findByUniqueId($uniqueId);
    }

    /**
     * @return MysqlConnectionInterface
     */
    private function getConnection(): MysqlConnectionInterface
    {
        return $this->_connection;
    }

    /**
     * @param array $user
     * @throws \Exception
     */
    private function createAlbumForUser(array $user): void
    {
        $albums = $this->getApi()->getAlbums($user['owner_id']);
        if (empty($albums['items'])) {
            throw new \Exception('Albums is empty');
        }
        foreach ($albums['items'] as $album) {
            $albumEntity = $this->getAlbum($album['id']);
            if (empty($albumEntity)) {
                (new AlbumRepository($this->getConnection()))->createAlbum([
                    'title' => $album['title'],
                    'created' => $album['created'],
                    'updated' => $album['updated'],
                    'album_id' => $album['id'],
                    'user_id' => $user['id'],
                ]);
                $albumEntity = $this->getAlbum($album['id']);
            }
            $this->createPhotoForAlbum($albumEntity, $user['owner_id']);
        }
    }

    /**
     * @param array $album
     * @param string $ownerId
     * @throws \Exception
     */
    private function createPhotoForAlbum(array $album, string $ownerId): void
    {
        $photos = $this->getApi()->getPhotos($album['unique_id'], $ownerId);
        if (empty($photos['items'])) {
            throw new \Exception('Photos is empty');
        }
        $repository = new PhotoRepository($this->getConnection());
        foreach ($photos['items'] as $photo) {
            $photoEntity = $this->getPhoto($album['id'], $photo['id']);
            if (empty($photoEntity)) {
                $repository->createPhoto([
                    'uniqueId' => $photo['id'],
                    'albumId' => $album['id'],
                    'url' => $photo['photo_130'],
                    'date' => $photo['date'],
                ]);
            }
        }
    }

    /**
     * @param string $albumId
     * @param $uniqueId
     * @return array|null
     */
    private function getPhoto(string $albumId, $uniqueId): ?array
    {
        return (new PhotoRepository($this->getConnection()))->findByAlbumAndUniqueId($albumId, $uniqueId);
    }

    /**
     * @return Client
     */
    protected function getApi(): Client
    {
        return $this->_api;
    }

}