<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Zombie\Application(realpath(__DIR__ . '/../'));

return $app->handle();
