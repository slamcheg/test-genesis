<?php


namespace App\Repositories;


use App\Components\Db\Mysql\QueryBuilder;
use App\Components\Repository\Mysql\Repository;

/**
 * Class AlbumRepository
 * @package App\Repositories
 */
class AlbumRepository extends Repository
{
    /**
     * @param array $entity
     * @return bool
     */
    public function createAlbum(array $entity): bool
    {
        return (new QueryBuilder())->insert("INSERT INTO album (title, user_id, unique_id, created_at, updated_at) VALUES (:albumTitle,:userId, :albumId,:created,:updated)", [
            ':albumTitle' => $entity['title'],
            ':userId' => $entity['user_id'],
            ':created' => $entity['created'],
            ':updated' => $entity['updated'],
            ':albumId' => $entity['album_id']
        ])->execute($this->getConnection());
    }

    /**
     * @param string $uniqueId
     * @return array|null
     */
    public function findByUniqueId(string $uniqueId): ?array
    {
        return (new QueryBuilder())
            ->select("SELECT * FROM album WHERE unique_id = :unique_id", [':unique_id' => $uniqueId])
            ->fetchOne($this->getConnection());
    }

    /**
     * @param int $userId
     * @return array|null
     */
    public function findByUserId(int $userId): ?array
    {
        return (new QueryBuilder())
            ->select("SELECT * FROM album WHERE user_id = :userId", [':userId' => $userId])
            ->fetchAll($this->getConnection());
    }

}