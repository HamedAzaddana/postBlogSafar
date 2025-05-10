<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Factories\ModelFactory;
use App\HQ\Router;
use App\HQ\DependencyInjector;
use App\Models\Post;
use App\Models\User;

session_start();

// Dependency Injection setup
$di = new DependencyInjector();
$di->register('PostModel', new Post());
$di->register('UserModel', new User());

// Initialize Router
$router = new Router();
$factory = new ModelFactory();
$router = new Router($factory); // Inject the factory
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
