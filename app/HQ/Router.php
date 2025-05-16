<?php

namespace App\HQ;

use FastRoute\RouteCollector;
use App\Factories\ModelFactoryInterface;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\MiddlewareInterface;

class Router
{
    private $dispatcher;
    private $middlewareStack = [];

    public function __construct()
    {
        // Define routes
        $this->dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $r) {
            require_once __DIR__ . "/../../routes/web.php";
        });
    }

    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewareStack[] = $middleware;
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
                $middlewreClasses = @$handler[2];
                if (!empty($middlewreClasses) && is_array($middlewreClasses)) {
                    foreach ($middlewreClasses as $middlewreClass) {
                        $reflectionClass = new \ReflectionClass($middlewreClass);
                        $middleware = $reflectionClass->newInstance();
                        $this->addMiddleware($middleware);
                    }
                }
                $this->handleMiddleware($httpMethod, $uri, function () use ($handler, $vars) {
                    $controller = new $handler[0]();
                    $method = $handler[1];
                    $controller->$method($vars);
                });
                break;
        }

        session_put('old_form', []);
    }

    private function handleMiddleware($httpMethod, $uri, $next)
    {
        $middlewareStack = $this->middlewareStack;

        $this->runMiddleware($middlewareStack, $httpMethod, $uri, $next);
    }

    private function runMiddleware($middlewareStack, $httpMethod, $uri, $next)
    {
        if (count($middlewareStack) > 0) {
            $middleware = array_shift($middlewareStack);

            return $middleware->handle($httpMethod, $uri, function ($httpMethod, $uri) use ($middlewareStack, $next) {
                return $this->runMiddleware($middlewareStack, $httpMethod, $uri, $next);
            });
        }

        return $next($httpMethod, $uri);
    }
}
