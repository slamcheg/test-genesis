<?php


namespace App\Repositories;

use App\Components\Db\Mysql\QueryBuilder;
use App\Components\Repository\Mysql\Repository;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends Repository
{
    /**
     * @param string $ownerId
     * @return array|null
     */
    public function findByOwnerId(string $ownerId): ?array
    {
        return (new QueryBuilder())
            ->select("SELECT * FROM user WHERE owner_id = :owner", [':owner' => $ownerId])
            ->fetchOne($this->getConnection());
    }

    /**
     * @param string $ownerId
     * @return bool
     */
    public function createUser(string $ownerId): bool
    {
        return (new QueryBuilder())
            ->insert("INSERT INTO user (owner_id) VALUES (?)", [1 => $ownerId])
            ->execute($this->getConnection());
    }

}