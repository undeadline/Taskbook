<?php

namespace App\Models;

use Zombie\Database\Model;

class Task extends Model
{
    /**
     * Fields is which available for sorting
     *
     * @var array
     */
    private static $sortable = ['name', 'email', 'status'];

    /**
     * Sorting directions
     *
     * @var array
     */
    private static $direction = ['desc', 'asc'];

    /**
     * Table name
     *
     * @var string
     */
    protected static $table = 'tasks';

    /**
     * Fields is which available for db query
     *
     * @var array
     */
    protected $fields = ['name', 'email', 'text', 'status', 'edited'];

    /**
     *
     *
     * @param $name
     * @return bool
     */
    public static function is_sortable($name)
    {
        return in_array($name, static::$sortable);
    }

    /**
     * @param $name
     * @return bool
     */
    public static function direction($name)
    {
        return in_array($name, static::$direction);
    }
}