<?php

use App\Framework\Config\_Global;
use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

$containerBuilder = new ContainerBuilder();

// Add DI container definitions
$containerBuilder->addDefinitions(__DIR__.DIRECTORY_SEPARATOR.'container.php');

// Create DI container instance
$container = $containerBuilder->build();

// Create Slim App instance
$app = $container->get(App::class);
$global = $container->get(_Global::class);

// Register routes
(require __DIR__.DIRECTORY_SEPARATOR.'routes.php')($app);

// Register middleware
(require __DIR__.DIRECTORY_SEPARATOR.'middleware.php')($app);

return $app;
