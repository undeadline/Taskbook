<?php

namespace Zombie;

use Zombie\Routing\Router;

class Application
{
    /**
     * Basepath to application
     *
     * @var
     */
    private $basepath;

    /**
     * Instance of request
     *
     * @var Request
     */
    private $request;

    /**
     * Application constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->basepath = $path;
        $this->parseDirectoryConfig($this->basepath);
        $this->request = new Request();
    }

    /**
     * Handle request
     *
     * @return View
     */
    public function handle()
    {
        $this->sessionStart();
        $router = new Router($this->request);
        $result = $router->getRoute();

        if ($result['route'] && class_exists('App\\Controllers\\' . $result['route']['controller'])) {
            $class = "\\App\\Controllers\\" . $result['route']['controller'];
            $controller = new $class($this->request);

            return $controller->{$result['route']['method']}(...$result['arguments']);
        }

        return new View(404, '404');
    }

    /**
     * Start session for current request
     */
    private function sessionStart()
    {
        session_start();
    }

    /**
     * Parse directory with config files
     *
     * @param $path
     */
    private function parseDirectoryConfig($path)
    {
        $names = scandir($path . '/config');
        $files = [];

        foreach($names as $name)
            if ($name !== '.' && $name !== '..')
                $files[basename($name, '.php')] = require_once $path . '/config/' .$name;

        $files['basepath'] = $path;

        Config::set($files);
    }
}