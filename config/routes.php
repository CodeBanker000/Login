<?php

use Slim\App;

return function(App $app) {

    require_once __DIR__ . '/../Modules/Index/routes.php';
    require_once __DIR__ . '/../Modules/Dashboard/routes.php';

};