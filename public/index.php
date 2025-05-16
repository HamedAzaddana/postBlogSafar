<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Factories\ModelFactory;
use App\HQ\Router;
use App\HQ\DependencyInjector;
use App\Models\Post;
use App\Models\User;

session_start();

$di = new DependencyInjector();
$di->register('PostModel', new Post());
$di->register('UserModel', new User());

$factory = new ModelFactory();
$router = new Router($factory); 
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
