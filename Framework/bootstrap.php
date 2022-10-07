<?php

use DI\ContainerBuilder;
use Slim\App;
use App\Framework\Config\_Global;

require_once __DIR__ . '/../vendor/autoload.php';


$containerBuilder = new ContainerBuilder();

// Add DI container definitions
$containerBuilder->addDefinitions(__DIR__ . '/container.php');

// Create DI container instance
$container = $containerBuilder->build();

// Create Slim App instance
$app = $container->get(App::class);
$global = $container->get(_Global::class);

// Load Database
// (require __DIR__ . '/database.php')($app);

// Register routes
(require __DIR__ . '/routes.php')($app);

// Register middleware
(require __DIR__ . '/middleware.php')($app);

return $app;