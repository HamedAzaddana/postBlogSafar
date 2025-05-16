<?php
namespace App\Middlewares;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle($request, $response, $next)
    {
       
        $user = session_get('user',null);
        if (empty($user)) {
            return redirect("/login");
            exit;
        }
        return $next($request, $response);
    }
}