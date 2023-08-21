<?php

use GrowBitTech\Framework\Config\Interface\GlobalInterface;
use Illuminate\Database\Capsule\Manager as DB;
use Slim\App;

return function (App $app) {
    $settings = $app->getContainer()->get(GlobalInterface::class);
    $capsule = new DB();
    $capsule->addConnection($settings->get('db'));
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
};
