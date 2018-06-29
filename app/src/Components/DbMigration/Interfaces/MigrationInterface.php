<?php

namespace App\Components\DbMigration\Interfaces;

use App\Components\Db\Interfaces\ExecutableQueryInterface;


/**
 * Interface Migration
 * @package App\Components\DbMigration\Interfaces
 */
interface MigrationInterface
{
    /**
     * @return ExecutableQueryInterface
     */
    public function up(): ExecutableQueryInterface;

    /**
     * @return ExecutableQueryInterface
     */
    public function down(): ExecutableQueryInterface ;
}