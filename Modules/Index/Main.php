<?php

declare(strict_types=1);

namespace Modules\Index;

use App\Model\User;
use LDAP\Result;
use Slim\Views\Twig;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class Main
{
    
    protected Twig $twig;

    public function __construct(protected ContainerInterface $container)
    {
        $this->container = $container;
        $this->twig = $container->get(Twig::class);
    }

    public function __invoke(Request $request, Response $response) :Response
    {
        return $this->twig->render($response, 'index.twig');
    }
}