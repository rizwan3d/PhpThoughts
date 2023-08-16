<?php

namespace GrowBitTech\Framework\RouteLoader;

use GrowBitTech\Framework\RouteLoader\Attributes\Route;

/**
 * Class ClassMethod.
 */
class ClassMethod
{
    protected string $className;

    protected string $methodName;

    protected Route $route;

    /**
     * ClassMethod constructor.
     *
     * @param string $className
     * @param string $methodName
     * @param Route  $route
     */
    public function __construct(string $className, string $methodName, Route $route)
    {
        $this->className = $className;
        $this->methodName = $methodName;
        $this->route = $route;
    }

     /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        $methodName = ($this->methodName === 'class') ? '__invoke' : $this->methodName;

        return $this->className.':'.$methodName;
    }

    /**
     * @return string
     */
    public function getRoutePattern(): string
    {
        return $this->route->getPattern();
    }

    /**
     * @return Middleware
     */
    public function getMiddleware()
    {
        return $this->route->getMiddleware();
    }

    /**
     * @return array
     */
    public function getRouteMethods(): array
    {
        return $this->route->getMethods();
    }

    /**
     * @return string|null
     */
    public function getRouteName(): ?string
    {
        return $this->route->getName();
    }
}
