<?php

namespace Zombie;

class Config
{
    /**
     * Contain data for config
     *
     * @var
     */
    private static $data;

    /**
     * Contain object of config
     *
     * @var null
     */
    private static $instance = null;

    /**
     * Config constructor.
     */
    private function __construct()
    {

    }

    /**
     * Singleton method
     *
     * @return Config|null
     */
    public static function instance()
    {
        if(is_null(self::$instance))
             self::$instance = new self();

        return self::$instance;
    }

    /**
     * Set data to config
     *
     * @param $data
     */
    public static function set($data)
    {
        self::$data = $data;
    }

    /**
     * Get data from config
     *
     * @param $name
     * @return mixed|null
     */
    public static function get($name)
    {
        $search = null;

        foreach(explode('.', $name) as $item) {
            if (array_key_exists($item, self::$data) && is_null($search))
                $search = self::$data[$item];
            else
                if (array_key_exists($item, $search))
                    $search = $search[$item];
        }

        return $search;
    }
}