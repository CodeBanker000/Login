<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Auth\Auth;
use Psr\Http\Server\RequestHandlerInterface as Handle;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class AuthMiddleware
{
    public function __construct(protected Auth $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(Request $request, Handle $handler)
    {
        $response = $handler->handle($request);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        $url = $routeParser->urlFor('home');

        if(!$this->auth->check())
            return $response->withHeader('Location', $url)->withStatus(302);

        return $response;
    }
}