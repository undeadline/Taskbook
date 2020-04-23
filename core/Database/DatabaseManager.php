<?php

namespace Zombie\Database;

class DatabaseManager
{
    /**
     * Factory method for getting db instance
     *
     * @param $type
     * @return mixed
     * @throws \Exception
     */
    public static function make($type)
    {
        if (method_exists(self::class, $type))
            return self::{$type}();

        throw new \Exception("Database {$type} is not exists");
    }

    /**
     * Return mysql instance
     *
     * @return \PDO|null
     */
    private static function mysql()
    {
        return MySQL::instance();
    }
}