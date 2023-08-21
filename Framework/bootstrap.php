<?php

use DI\ContainerBuilder;
use GrowBitTech\Framework\Config\Interface\GlobalInterface;
use Slim\App;

require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
$setings = require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Global.php';

$containerBuilder = new ContainerBuilder();
if(!$setings['dev_mode'])
    $containerBuilder->enableCompilation($setings['cache_dir']);

// Add DI container definitions
$containerBuilder->addDefinitions(__DIR__.DIRECTORY_SEPARATOR.'container.php');

// Create DI container instance
$container = $containerBuilder->build();

// Create Slim App instance
$app = $container->get(App::class);
$global = $container->get(GlobalInterface::class);

// Register routes
(require __DIR__.DIRECTORY_SEPARATOR.'routes.php')($app);

// Register middleware
(require __DIR__.DIRECTORY_SEPARATOR.'middleware.php')($app);

return $app;
