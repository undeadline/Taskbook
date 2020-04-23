<?php

return [
    ["type" => "get", "url" => "/", "controller" => "HomeController", "method" => "index"],
    ["type" => "get", "url" => "/login", "controller" => "LoginController", "method" => "index"],
    ["type" => "get", "url" => "/logout", "controller" => "LoginController", "method" => "logout"],
    ["type" => "get", "url" => "/register", "controller" => "RegisterController", "method" => "index"],
    ["type" => "get", "url" => "/tasks/(\d+)", "controller" => "TaskController", "method" => "show"],
    ["type" => "post", "url" => "/tasks/(\d+)", "controller" => "TaskController", "method" => "update"],
    ["type" => "post", "url" => "/tasks", "controller" => "TaskController", "method" => "create"],
    ["type" => "post", "url" => "/login", "controller" => "LoginController", "method" => "login"],
    ["type" => "post", "url" => "/register", "controller" => "RegisterController", "method" => "register"],
];