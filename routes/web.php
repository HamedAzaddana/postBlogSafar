<?php

use App\Middlewares\AuthMiddleware;

// Authentication routes
$r->addRoute('GET', '/login', ['App\Controllers\AuthController', 'showLogin']);
$r->addRoute('GET', '/register', ['App\Controllers\AuthController', 'showRegister']);
$r->addRoute('POST', '/login', ['App\Controllers\AuthController', 'login']);
$r->addRoute('POST', '/register', ['App\Controllers\AuthController', 'register']);
$r->addRoute('GET', '/logout', ['App\Controllers\AuthController', 'logout']);

// Post resource routes
$r->addRoute('GET', '/', ['App\Controllers\PostController', 'home']);
$r->addRoute('GET', '/posts', ['App\Controllers\PostController', 'index',[AuthMiddleware::class]]);
$r->addRoute('GET', '/uploads/{name}', ['App\Controllers\PostController', 'getFile']);
$r->addRoute('GET', '/posts/{id:\d+}', ['App\Controllers\PostController', 'show']);
$r->addRoute('POST', '/posts', ['App\Controllers\PostController', 'create']);
$r->addRoute('PUT', '/posts/{id:\d+}', ['App\Controllers\PostController', 'update']);
$r->addRoute('DELETE', '/posts/{id:\d+}', ['App\Controllers\PostController', 'delete']);

