<?php

namespace Zombie\Database;

use Zombie\Config;

class MySQL implements IDatabase
{
    /**
     * Instance
     *
     * @var null
     */
    private static $instance = null;

    /**
     * MySQL constructor.
     */
    private function __construct()
    {
    }

    /**
     * Singleton method
     *
     * @return \PDO|null
     * @throws \Exception
     */
    public static function instance()
    {
        if(is_null(self::$instance))
            self::$instance = (new self())->connection();

        return self::$instance;
    }

    /**
     * Connection to database
     *
     * @return \PDO
     * @throws \Exception
     */
    public function connection(): \PDO
    {
        try {
            return new \PDO(
                Config::get('database.settings.mysql.dns'),
                Config::get('database.settings.mysql.username'),
                Config::get('database.settings.mysql.password'),
                Config::get('database.settings.mysql.options')
            );
        } catch(\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}