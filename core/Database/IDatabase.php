<?php

namespace Zombie\Database;

interface IDatabase
{
    /**
     * Method for connection to database should return PDO object
     *
     * @return \PDO
     */
    public function connection(): \PDO;
}