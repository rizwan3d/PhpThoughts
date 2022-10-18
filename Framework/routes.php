<?php

use App\Framework\RouteLoader\FileLoader;
use App\Framework\RouteLoader\RouteCollector;
use Slim\App;

return function (App $app) {
    $paths = [];
    foreach (scandir($path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Modules') as $dir) {
        if ($dir == '.' || $dir == '..') {
            continue;
        }
        $paths[] = dirname($path, 3).DIRECTORY_SEPARATOR.'Modules'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.'Presentation'.DIRECTORY_SEPARATOR.'Action'.DIRECTORY_SEPARATOR;
    }
    $fileLoader = new FileLoader($paths);
    if (empty($fileLoader)) {
        return;
    }
    $classMethods = RouteCollector::findClassMethods($fileLoader->getFiles());
    if (empty($classMethods)) {
        return;
    }
    $routePatterns = [];
    foreach ($classMethods as $methodName => $classMethod) {
        $routePattern = $classMethod->getRoutePattern();
        $requestMethods = $classMethod->getRouteMethods();
        $requestMiddleware = $classMethod->getMiddleware();
        // Check for duplicate entries
        if (array_key_exists($routePattern, $routePatterns)) {
            $nrOfCurrentRequestMethods = count($routePatterns[$routePattern]['requestMethods']);
            $diff = array_diff($routePatterns[$routePattern]['requestMethods'], $requestMethods);
            if ($nrOfCurrentRequestMethods !== count($diff)) {
                continue;
            }
        }
        $rote = null;
        switch ($requestMethods[0]) {
            case 'GET':
                $rote = $app->get($routePattern, $classMethod->getMethodName());
                break;
            case 'POST':
                $rote = $app->post($routePattern, $classMethod->getMethodName());
                break;
            case 'PUT':
                $rote = $app->put($routePattern, $classMethod->getMethodName());
                break;
            case 'PATCH':
                $rote = $app->patch($routePattern, $classMethod->getMethodName());
                break;
            case 'DELETE':
                $rote = $app->delete($routePattern, $classMethod->getMethodName());
                break;
            default:
                break;
        }

        if ($rote && $requestMiddleware) {
            if (is_array($requestMiddleware) && count($requestMiddleware) > 0) {
                foreach ($requestMiddleware as $middleware) {
                    $rote->add($middleware);
                }
            } else {
                $rote->add($requestMiddleware);
            }
        }
    }
};
