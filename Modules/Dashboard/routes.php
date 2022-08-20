<?php

use App\Middleware\AuthMiddleware;
use Modules\Dashboard\Login;
use Modules\Dashboard\Logout;

// map the authentication route

$app->post('/dashboard', Login::class)->add(AuthMiddleware::class);
$app->post('/logout', Logout::class)->add(AuthMiddleware::class);