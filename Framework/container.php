<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use App\Framework\Config\_Global;

return [
    
    _Global::class => function (ContainerInterface $container) {
        $data = require __DIR__ . '/../Global.php';
        return new _Global($data);
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        
        // Should be set to 0 in production
        error_reporting(E_ALL);

        // Should be set to '0' in production
        ini_set('display_errors', '1');

        return AppFactory::create();
    },


];