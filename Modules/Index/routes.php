<?php

use Modules\Index\Main;

// map the web route

$app->get('/', Main::class)->setName('home');
