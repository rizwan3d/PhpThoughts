<?php

$settings = [
    'php' => 'php83', // Remove this key if you to use default php
    'DevMode' => true,  // prod
    'AuthKey'  => 'ASSIGNMENTKEY',
    'Swager'   => true,

    'Logger' => [
        // Log file location
        'Path' => __DIR__.'\Logs',
        // Default log level
        'Level' => \Monolog\Level::Info,
    ],

    // Path where Doctrine/DI will cache the processed metadata
    // when 'DevMode' is false.
    'CacheDir' => __DIR__.'\Cache',

    'Socket' => [
        'Host'         => 'localhost',
        'Port'         => '6001',
        'IsRadis'      => true,
        'RadisChannel' => 'socket',
        'Redis'        => [
            'Scheme'             => 'tcp',
            'Host'               => '127.0.0.1',
            'Port'               => 6379,
            'Database'           => 0,
            'ReadWriteTimeout' => 0,
        ],
    ],

    // The parameters Doctrine needs to connect to your database.
    // These parameters depend on the driver (for instance the 'pdo_sqlite' driver
    // needs a 'path' parameter and doesn't use most of the ones shown in this example).
    // Refer to the Doctrine documentation to see the full list
    // of valid parameters: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html
    'DB' => [
        'Driver'   => 'pdo_mysql',
        'Host'     => '127.0.0.1',
        'Port'     => 3306,
        'DbName'   => 'noname',
        'User'     => 'root',
        'Password' => '',
        'Charset'  => 'utf8',
    ],
    'AutoDBSchemaUpdate' => true,
];

return $settings;
