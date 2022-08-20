<?php

use Slim\App;
use App\Model\User;
use Medoo\Medoo;
use App\Auth\Auth;
use App\Middleware\AuthMiddleware;
use Slim\Views\Twig;
use DI\ContainerBuilder;
use Odan\Session\PhpSession;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Twig\Loader\FilesystemLoader;
use Psr\Container\ContainerInterface;

return [

    # parameters
    'settings' => function() {
        return require __DIR__ . '/settings.php';
    },
    
    # App service
    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        
        $app = AppFactory::create();

        return $app;
    },

    # Views service
    Twig::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['twig'];
        $loader = new FilesystemLoader($settings['views']);


        
        return new Twig($loader, $settings['config']);
    },

    TwigMiddleware::class => function (ContainerInterface $container) {
        $routeParser = $container->get(App::class)->getRouteCollector()->getRouteParser();

        return new TwigMiddleware($container->get(Twig::class), $routeParser);
    },

    # Database service
    'db' => function(ContainerInterface $container) {
        
        if (!isset($container->get('settings')['database']))
            die('The configuration of database is missing!');

        $settings = $container->get('settings')['database'];

        $medoo = new Medoo([
            'type' => $settings['db_type'],
            'host' => $settings['db_host'],
            'database' => $settings['db_name'],
            'username' => $settings['db_user'],
            'password' => $settings['db_pass'],
            'charset' => $settings['db_charset'],
            'collation' => $settings['db_collection'],
            'port' => $settings['db_port']
        ]);

        return $medoo;
    },

    User::class => function (ContainerInterface $container) {
        return new User($container->get('db'));
    },

    Auth::class => function (ContainerInterface $container) {
        return new Auth($container);
    },

    PhpSession::class => function (ContainerInterface $container) {
        $session = new PhpSession();

        $session->setOptions([
            'name' => 'user'
        ]);

        return $session;
    }
];