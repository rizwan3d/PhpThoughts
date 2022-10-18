<?php

use App\Framework\Config\_Global;
use Illuminate\Database\Capsule\Manager as DB;
use Slim\App;

return function (App $app) {
    $settings = $app->getContainer()->get(_Global::class);
    $capsule = new DB();
    $capsule->addConnection($settings->get('db'));
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
};
