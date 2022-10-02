<?php

use Slim\App;
use Selective\BasePath\BasePathMiddleware;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    $app->add(new BasePathMiddleware($app));

    // Handle exceptions
    $app->addErrorMiddleware(true, true, true);
};