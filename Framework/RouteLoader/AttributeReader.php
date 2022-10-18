<?php

namespace GrowBitTech\Framework\RouteLoader;

use GrowBitTech\Framework\RouteLoader\Attributes\Route;
use GrowBitTech\Framework\RouteLoader\Exception\AttributeReaderException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use SplFileObject;

/**
 * Class PhpAttributeReader.
 */
class AttributeReader
{
    public const REGEX_NAMESPACE = '#namespace +([-_a-z0-9\\\]+)( +)?;#i';
    public const REGEX_CLASS = '#(?<!abstract )class +([a-z_\x80-\xff][a-z0-9_\x80-\xff]*)#i';

    protected SplFileObject $phpFile;

    protected ?string $namespace = null;

    protected ?string $className = null;

    /**
     * @var array array containing allowed search type
     */
    protected array $allowedTypes = [
        'namespace',
        'className',
    ];

    public function __construct(SplFileObject $phpFile)
    {
        $this->phpFile = $phpFile;
    }

    /**
     * findClassMethodInfo.
     *
     * get array of ClassMethod containing method name and cleaned docblock
     *
     * @todo investigate if token_get_all($fileContent) would be faster then using regex
     *
     * @throws AttributeReaderException
     * @throws ReflectionException
     *
     * @return ClassMethod[]
     */
    public function findClassMethodInfo(): array
    {
        $result = [];

        /**
         * note: namespace will always proceed class, so as soon as we find a Classname, we can terminate loop.
         */
        // get class name (including namespace from file (stop at first hit))
        while (!$this->phpFile->eof()) {
            $line = $this->phpFile->fgets();

            // find namespace
            $this->search('namespace', $line);

            // find class
            $this->search('className', $line);

            if (empty($this->className)) {
                // if no class name has been set, read next line
                continue;
            }

            // We found class, get all public methods from class and fetch docBlock
            $fullClassName = $this->getFqClassName();
            if (class_exists($fullClassName) === false) {
                $msg = 'Unable to parse file: '.$this->phpFile->getFilename().
                    ', class: '.$fullClassName.' not found';

                throw new AttributeReaderException($msg);
            }

            $result = $this->findMethodsWithRouteAttribute($fullClassName);

            // we found class no need to further parse .php file, terminate while loop
            break;
        }

        return $result;
    }

    public function getFile(): SplFileObject
    {
        return $this->phpFile;
    }

    public function getFqClassName(): ?string
    {
        $className = null;
        if (isset($this->className)) {
            $className = $this->namespace.'\\'.$this->className;
        }

        return $className;
    }

    /**
     * search.
     *
     * search for "type" definition given a single line as string
     *
     * @param string $type allowed values namespace|className
     * @param string $line returns true if we found "type" and sets "type" property name
     *
     * @throws AttributeReaderException
     *
     * @return bool
     */
    protected function search(string $type, string $line): bool
    {
        if (!in_array($type, $this->allowedTypes, true)) {
            throw new AttributeReaderException('Invalid attribute search type: '.$type);
        }

        if (isset($this->$type)) {
            return true;
        }

        switch ($type) {
            case 'namespace':
                $regex = self::REGEX_NAMESPACE;
                break;

            case 'className':
                $regex = self::REGEX_CLASS;
                break;
        }

        preg_match($regex, $line, $matches);
        $this->$type = !empty($matches[1]) ? $matches[1] : null;

        return !empty($this->$type);
    }

    /**
     * @param string $fullClassName
     *
     * @throws ReflectionException
     *
     * @return ClassMethod[]
     */
    protected function findMethodsWithRouteAttribute(string $fullClassName): array
    {
        $result = [];
        $reflectionClass = new ReflectionClass($fullClassName);
        $classMethods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

        // Find routes for all public methods
        foreach ($classMethods as $method) {
            if ($method->name === '__construct') {
                // it is not possible link a route to the construct method
                continue;
            }

            if ($method->class !== $reflectionClass->getName()) {
                // Don't add inherited class methods
                continue;
            }

            $route = $this->findRoute($method);

            if ($route === null) {
                // if no route found, continue to next method
                continue;
            }

            $result[$fullClassName.'::'.$method->name] = new ClassMethod(
                $fullClassName,
                $method->name,
                $route
            );
        }

        /**
         * Add __invoke route if defined on class object level.
         *
         * If a class has an __invoke method, we can also specify the route on the class object itself.
         *
         * To ensure we don't add duplicate Route definitions for the __invoke route, we will only check if a
         * class route attribute exists if we haven't previously registered an __invoke method in above code.
         */
        $invokeMethodName = '__invoke';
        $invokeMethodNameFq = $fullClassName.'::'.$invokeMethodName;
        if (!isset($result[$invokeMethodNameFq]) && $reflectionClass->hasMethod($invokeMethodName)) {
            $route = $this->findRoute($reflectionClass);

            if ($route !== null) {
                $result[$invokeMethodNameFq] = new ClassMethod(
                    $fullClassName,
                    $invokeMethodName,
                    $route
                );
            }
        }

        return $result;
    }

    protected function findRoute(ReflectionMethod|ReflectionClass $reflectionObject): ?Route
    {
        $attributes = $reflectionObject->getAttributes(
            Route::class,
            ReflectionAttribute::IS_INSTANCEOF
        );

        if (empty($attributes)) {
            return null;
        }

        $routeAttribute = array_pop($attributes);

        return $routeAttribute->newInstance();
    }
}
