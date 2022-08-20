<?php

return [
    'twig' => [
        'views' => realpath(__DIR__ . '/../Templates'),
        'config' => [
            'cache' => false
        ]
    ],
    'error' => [
        'displayErrorDetails' => true,
        'logErrorDetails' => true,
        'logError' => true
    ],

    'database' => [
        'db_type' => 'mysql',
        'db_host' => 'localhost',
        'db_port' => '3306',
        'db_user' => 'root',
        'db_pass' => '',
        'db_name' => 'login',
        'db_charset' => 'utf8mb4',
        'db_collection' => 'utf8mb4_unicode_ci'
    ]
];
