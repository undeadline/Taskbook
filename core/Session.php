<?php

namespace Zombie;

class Session
{
    /**
     * Session instance
     *
     * @var null
     */
    private static $instance = null;

    /**
     * Session constructor.
     */
    private function __construct()
    {
    }

    /**
     * Singleton method
     *
     * @return Session|null
     */
    public static function instance()
    {
        if(is_null(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    /**
     * Check what key is exists in session
     *
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return isset($_SESSION[$name]) ? true : false;
    }

    /**
     * Set parameter in session
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get parameter from session
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Delete parameter from session
     *
     * @param $key
     */
    public function delete($key)
    {
        unset($_SESSION[$key]);
    }
}