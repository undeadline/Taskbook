<?php

if(!function_exists('response')) {
    function response()
    {
        return new \Zombie\Response();
    }
}

if(!function_exists('request')) {
    function request()
    {
        return new \Zombie\Request();
    }
}

if(!function_exists('session')) {
    function session()
    {
        return \Zombie\Session::instance();
    }
}

if(!function_exists('auth')) {
    function auth()
    {
        return session()->get('user');
    }
}

if(!function_exists('abort')) {
    function abort_404()
    {
        return new Zombie\View(404, '404');
    }
}
