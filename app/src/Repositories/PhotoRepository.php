<?php


namespace App\Repositories;


use App\Components\Db\Mysql\QueryBuilder;
use App\Components\Helpers\DbHelper;
use App\Components\Repository\Mysql\Repository;

/**
 * Class AlbumRepository
 * @package App\Repositories
 */
class PhotoRepository extends Repository
{
    /**
     * @param array $entity
     * @return bool
     */
    public function createPhoto(array $entity): bool
    {
        return (new QueryBuilder())->insert("INSERT INTO photo (unique_id, album_id, url,date) VALUES (:uniqueId,:albumId, :url,:date)", [
            ':albumId' => $entity['albumId'],
            ':uniqueId' => $entity['uniqueId'],
            ':url' => $entity['url'],
            ':date' => $entity['date'],
        ])->execute($this->getConnection());
    }

    /**
     * @param string $albumId
     * @param string $uniqueId
     * @return array|null
     */
    public function findByAlbumAndUniqueId(string $albumId, string $uniqueId): ?array
    {
        return (new QueryBuilder())->select("SELECT * FROM photo WHERE unique_id = :uniqueId AND album_id = :albumId", [
            ':uniqueId' => $uniqueId,
            ':albumId' => $albumId,
        ])->fetchOne($this->getConnection());
    }

    /**
     * @param array $albumsId
     * @return array
     */
    public function findByAlbumsId(array $albumsId)
    {
        //TODO по хорошему вынести getBindValues и getBindKeys в QueryBuilder

        $preparedInValues = DbHelper::getBindValues($albumsId);
        $bindKeys = DbHelper::getBindKeys($preparedInValues);
        return (new QueryBuilder())
            ->select('SELECT * FROM photo WHERE album_id  IN(' .$bindKeys. ')', $preparedInValues)
            ->fetchAll($this->getConnection());
    }
}