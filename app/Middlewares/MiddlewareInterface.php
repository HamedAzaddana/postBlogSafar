<?php
namespace App\Middlewares;

interface MiddlewareInterface
{
    public function handle($request, $response, $next);
}
