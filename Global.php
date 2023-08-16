<?php

$settings = [
    'dev_mode' => true,  // prod
    'authkey' => 'ASSIGNMENTKEY',

    // Path where Doctrine will cache the processed metadata
    // when 'dev_mode' is false.
    'cache_dir' => __DIR__.'/cache/doctrine',

    'socket' => [
        'host'         => 'localhost',
        'port'         => '6001',
        'isRadis'      => true,
        'radisChannel' => 'socket',
        'redis'        => [
            'scheme'             => 'tcp',
            'host'               => '127.0.0.1',
            'port'               => 6379,
            'database'           => 0,
            'read_write_timeout' => 0,
        ],
    ],

    // The parameters Doctrine needs to connect to your database.
    // These parameters depend on the driver (for instance the 'pdo_sqlite' driver
    // needs a 'path' parameter and doesn't use most of the ones shown in this example).
    // Refer to the Doctrine documentation to see the full list
    // of valid parameters: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html
    'db' => [
        'driver'   => 'pdo_mysql',
        'host'     => '127.0.0.1',
        'port'     => 3306,
        'dbname'   => 'noname',
        'user'     => 'root',
        'password' => '',
        'charset'  => 'utf8',
    ],
];

return $settings;
