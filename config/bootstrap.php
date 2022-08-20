<?php 

use Slim\App;

use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

#create the container builder, load the settings and the services
$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions(require __DIR__ . '/container.php');

$container = $containerBuilder->build();

#create instance of the app
$app = $container->get(App::class);

#register middleware
(require __DIR__ . '/middleware.php')($app); 

#register routes
(require __DIR__ . '/routes.php')($app);

return $app;