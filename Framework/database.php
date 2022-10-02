<?php

use Slim\App;
use \Illuminate\Database\Capsule\Manager as DB;
use App\Framework\Config\_Global;

return function (App $app) {
    $settings = $app->getContainer()->get(_Global::class);
    $capsule = new DB();
    $capsule->addConnection($settings->get('db'));
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
};