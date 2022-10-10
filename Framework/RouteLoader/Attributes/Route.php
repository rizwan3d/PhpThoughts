<?php

namespace App\Framework\RouteLoader\Attributes;

use Attribute;
use InvalidArgumentException;

#[Attribute(Attribute::TARGET_METHOD|Attribute::TARGET_CLASS)]
class Route
{
    protected string $pattern;

    protected array $methods;

    protected ?string $name;

    protected $middleware;

    protected array $allowedMethods = [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
        'OPTIONS',
        'HEAD',
    ];

    public function __construct(string $pattern, array $methods,$middleware = null, ?string $name = null)
    {
        $this->setPattern($pattern);
        $this->setMethods($methods);
        $this->setName($name);
        $this->setMiddleware($middleware);
    }

    public function setMiddleware($middleware = null)
    {
        $this->middleware = $middleware;
    }

    public function setPattern(string $pattern): void
    {
        $pattern = trim($pattern);
        if (empty($pattern) || $pattern[0] !== '/') {
            throw new InvalidArgumentException('pattern, can not be empty and needs to start with a: "/"');
        }

        $this->pattern = $pattern;
    }

    public function setMethods(array $methods): void
    {
        foreach ($methods as $method) {
            if (!in_array($method, $this->allowedMethods, true)) {
                throw new InvalidArgumentException(
                    'methods, invalid method name supplied, allowed list: '.implode(', ', $this->allowedMethods)
                );
            }
        }

        if (empty($methods)) {
            throw new InvalidArgumentException(
                'methods, can not be empty, allowed list: '.implode(', ', $this->allowedMethods)
            );
        }

        $this->methods = $methods;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }
}