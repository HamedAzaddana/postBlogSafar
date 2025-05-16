<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\HQ\Router;

session_start();
$router = new Router(); 
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
