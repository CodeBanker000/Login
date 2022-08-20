<?php

declare(strict_types=1);

namespace Modules\Dashboard;

use App\Auth\Auth;
use Slim\Routing\RouteContext;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class Logout
{

    protected Auth $auth;

    public function __construct(protected ContainerInterface $container)
    {
        $this->container = $container;
        $this->auth = $container->get(Auth::class);
    }

    public function __invoke(Request $request, Response $response) :Response
    {
        $this->auth->signOut();

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        $url = $routeParser->urlFor('home');

        return $response->withHeader('Location', $url)->withStatus(302);
    }
}