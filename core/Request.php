<?php

namespace Zombie;

class Request
{
    /**
     * Contain data from $_POST array
     *
     * @var
     */
    private $body;

    /**
     * Contain data from $_GET array
     *
     * @var
     */
    private $query;

    /**
     * Uri for current request
     *
     * @var
     */
    private $uri;

    /**
     * Contain files
     *
     * @var
     */
    private $files;

    /**
     * Type of request
     *
     * @var mixed
     */
    private $method;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->body = $_POST;
        $this->query = $_GET;
        $this->uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->files = $_FILES;
    }

    /**
     * Get files
     *
     * @return mixed
     */
    public function files()
    {
        return $this->files;
    }

    /**
     * Get method of request
     *
     * @return mixed
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * Get uri
     *
     * @return mixed
     */
    public function uri()
    {
        return $this->uri;
    }

    /**
     * Check what array of items contain in query
     *
     * @param $attributes
     * @return bool
     */
    public function has($attributes)
    {
        if (is_array($attributes))
            foreach($attributes as $item)
                if (!array_key_exists($item, $this->query))
                    return false;

        return true;
    }

    /**
     * Get query parameter
     *
     * @param $param
     * @return |null
     */
    public function query($param)
    {
        if (array_key_exists($param, $this->query))
            return $this->query[$param];

        return null;
    }

    /**
     * Return instance of session
     *
     * @return Session|null
     */
    public function session()
    {
        return Session::instance();
    }

    /**
     * Get errors for current request
     *
     * @return mixed
     */
    public function errors()
    {
        return isset($_SESSION['errors']) ? $_SESSION['errors'] : null;
    }

    /**
     * Get error by name
     *
     * @param $name
     * @return mixed
     */
    public function error($name)
    {
        return isset($_SESSION['errors']) ? $_SESSION['errors'][$name] : null;
    }

    /**
     * Get first error by name
     *
     * @param $name
     * @return mixed
     */
    public function first($name)
    {
        return $this->error($name)[0];
    }

    /**
     * Validator for request
     *
     * @param $rules
     * @param $data
     * @param array $messages
     * @return Validator
     */
    public function validate($rules, $data, $messages = [])
    {
        return new Validator($rules, $data, $messages);
    }

    /**
     * Get query array
     *
     * @return mixed
     */
    public function queryAll()
    {
        return $this->query;
    }

    /**
     * Get specific property from $_POST
     *
     * @param string $param
     * @return null
     */
    public function get(string $param)
    {
        if (array_key_exists($param, $this->body))
            return $this->body[$param];

        return null;
    }

    /**
     * Get all properties from $_POST
     *
     * @return mixed
     */
    public function all()
    {
        return $this->body;
    }
}