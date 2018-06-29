<?php


namespace App\Components\DbMigration\Interfaces;


/**
 * Interface ExecutorInterface
 * @package App\Components\DbMigration\Interfaces
 */
interface ExecutorInterface
{
    public function upMigrations(): void;

    public function downMigrations(): void;
}