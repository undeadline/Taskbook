<?php

namespace Zombie\Routing;

use Zombie\Config;

class Router
{
    /**
     * Array of routes
     *
     * @var mixed|null
     */
    private $routes;

    /**
     * Instance of current request
     *
     * @var
     */
    private $request;

    /**
     * Router constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
        $this->routes = Config::get('routes');
    }

    /**
     * Find route and transfer the request to controller method
     *
     * @return array|null
     */
    public function getRoute()
    {
        foreach($this->routes as $route)
            if (preg_match("#^{$route['url']}$#", $this->request->uri(), $matches)
                && $this->request->method() === strtoupper($route['type'])) {
                array_shift($matches);
                return ['route' => $route, 'arguments' => $matches];
            }

        return null;
    }
}