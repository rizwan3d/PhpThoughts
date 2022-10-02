<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use App\Framework\Config\_Global;
use App\Auth\Presentation\Action\UserAction;

return function (App $app,_Global $global) {
    $app->get('/user', UserAction::class);
};