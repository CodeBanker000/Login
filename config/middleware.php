<?php

use App\Auth\Auth;
use Slim\App;
use Slim\Views\TwigMiddleware;
use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;
use App\Middleware\AuthMiddleware;

return function (App $app) {

    $settings = $app->getContainer()->get('settings')['error'];

    # Parse json, form data and xml
    $app->addBodyParsingMiddleware();
    $app->add($app->getContainer()->get(TwigMiddleware::class));
    $app->add(new AuthMiddleware($app->getContainer()->get(Auth::class)));

    # Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    # Handle exceptions
    /* $app->addErrorMiddleware(
        $settings['displayErrorDetails'],
        $settings['logErrorDetails'],
        $settings['logError']
    );  */
    $app->add(new WhoopsMiddleware());
};