<?php

namespace App\HQ;

use FastRoute\RouteCollector;
use App\Factories\ModelFactoryInterface;

class Router
{
    private $dispatcher;

    public function __construct()
    {
        $this->dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $r) {
            // Authentication routes
            $r->addRoute('GET', '/login', ['App\Controllers\AuthController', 'showLogin']);
            $r->addRoute('GET', '/register', ['App\Controllers\AuthController', 'showRegister']);
            $r->addRoute('POST', '/login', ['App\Controllers\AuthController', 'login']);
            $r->addRoute('POST', '/register', ['App\Controllers\AuthController', 'register']);
            $r->addRoute('GET', '/logout', ['App\Controllers\AuthController', 'logout']);

            // Post resource routes
            $r->addRoute('GET', '/posts', ['App\Controllers\PostController', 'index']);
            $r->addRoute('GET', '/uploads/{name}', ['App\Controllers\PostController', 'getFile']);
            $r->addRoute('GET', '/posts/{id:\d+}', ['App\Controllers\PostController', 'show']);
            $r->addRoute('POST', '/posts', ['App\Controllers\PostController', 'create']);
            $r->addRoute('PUT', '/posts/{id:\d+}', ['App\Controllers\PostController', 'update']);
            $r->addRoute('DELETE', '/posts/{id:\d+}', ['App\Controllers\PostController', 'delete']);
        });
    }

    public function dispatch($httpMethod, $uri)
    {
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                echo "404 Not Found";
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                echo "405 Method Not Allowed";
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $controller = new $handler[0]();
                $method = $handler[1];
                $controller->$method($vars);
                break;
        }
        session_put('old_form',[]);

    }
}
