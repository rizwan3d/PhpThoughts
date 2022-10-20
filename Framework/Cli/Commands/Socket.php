<?php

namespace GrowBitTech\Framework\Cli\Commands;

use GrowBitTech\Framework\Cli\Command;
use GrowBitTech\Framework\Cli\Interface\CommandInterface;
use GrowBitTech\Framework\RouteLoader\FileLoader;
use GrowBitTech\Framework\RouteLoader\RouteCollector;

final class Socket extends Command implements CommandInterface
{
    public function validate(): CommandInterface
    {
        return $this;
    }

    public function run()
    {
        $settings = $this->settings->get('socket');
        $app = new \Ratchet\App($settings['host'], $settings['port']);

        $path = dirname(__DIR__, 3).DIRECTORY_SEPARATOR.'Modules'.DIRECTORY_SEPARATOR.'Socket'.DIRECTORY_SEPARATOR;
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
