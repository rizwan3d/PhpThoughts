<?php

namespace App\Framework\Cli\Commands;

use App\Framework\Cli\Interface\CommandInterface;
use App\Framework\Cli\Command;
use App\Framework\Config\_Global;
use App\Framework\RouteLoader\FileLoader;
use App\Framework\RouteLoader\RouteCollector;

final class Socket extends Command implements CommandInterface
{


    public function validate() : CommandInterface
    {
        return $this;
    }

    public function run()
    {
        $settings = $this->settings->get('socket');
        $app = new \Ratchet\App($settings['host'], $settings['port']);

        $path = __DIR__;
        $path = dirname($path, 3).'\\Modules\\Socket\\';
        $fileLoader = new FileLoader([$path]);
        if (empty($fileLoader)) {
            return;
        }
        $classMethods = RouteCollector::findClassMethods($fileLoader->getFiles());
        if (empty($classMethods)) {
            return;
        }
        foreach ($classMethods as $methodName => $classMethod) {
            $routePattern = $classMethod->getRoutePattern();
            $className = explode(':', $classMethod->getMethodName())[0];
            $app->route($routePattern, new ($className), ['*']);
        }

        $app->run();
    }
}
