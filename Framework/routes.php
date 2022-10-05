<?php

use Slim\App;
use App\Framework\Config\_Global;
use Slim\Factory\AppFactory;
use SquidIT\Slim\Routing\AttributeRouteCollector;
use Slim\CallableResolver;
use App\Framework\RouteLoader\FileLoader;
use App\Framework\RouteLoader\RouteCollector;

return function (App $app)
{
    $paths = [];
    foreach (scandir($path = __DIR__ . '/../Modules') as $dir)
    {
        if ($dir == "." || $dir == "..") continue;
        $paths[] = dirname($path, 3) . "\\Modules\\{$dir}\\Presentation\\Action\\";
    }
    $fileLoader = new FileLoader($paths);
    if (empty($fileLoader)) return;
    $classMethods = RouteCollector::findClassMethods($fileLoader->getFiles());
    if (empty($classMethods)) return;
    $routePatterns = [];
    foreach ($classMethods as $methodName => $classMethod)
    {
        $routePattern = $classMethod->getRoutePattern();
        $requestMethods = $classMethod->getRouteMethods();
        // Check for duplicate entries
        if (array_key_exists($routePattern, $routePatterns))
        {
            $nrOfCurrentRequestMethods = count($routePatterns[$routePattern]['requestMethods']);
            $diff = array_diff($routePatterns[$routePattern]['requestMethods'], $requestMethods);
            if ($nrOfCurrentRequestMethods !== count($diff))
            {
                continue;
            }
        }
        switch ($requestMethods[0])
        {
            case 'GET':
                $app->get($routePattern, $classMethod->getMethodName());
            break;
            case 'POST':
                $app->post($routePattern, $classMethod->getMethodName());
            break;
            case 'PUT':
                $app->put($routePattern, $classMethod->getMethodName());
            break;
            case 'PATCH':
                $app->patch($routePattern, $classMethod->getMethodName());
            break;
            case 'DELETE':
                $app->delete($routePattern, $classMethod->getMethodName());
            break;
            case 'HEAD':
                $app->head($routePattern, $classMethod->getMethodName());
            break;
            default:
            break;
        }
    }
};
    
