<?php
declare(strict_types=1);

namespace GrowBitTech\Framework\Strategies;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\InvocationStrategyInterface;

/**
 * Default route callback strategy with route parameters as an array of arguments.
 */
class RequestResponse implements InvocationStrategyInterface
{
    /**
     * Invoke a route callable with request, response, and all route parameters
     * as an array of arguments.
     *
     * @param array<string, string>  $routeArguments
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    ): ResponseInterface {
       
        foreach ($routeArguments as $k => $v) {
            $request = $request->withAttribute($k, $v);
        }
       
        if(is_array($callable)){
            $m = null;
            if (preg_match('~^(:?(?<reference>self|parent)::)?(?<method>[a-z_][a-z0-9_]*)$~i', $callable[1], $m)) {
                list($left, $right) = [$callable[0], $m['method']];
                $reflection = new \ReflectionMethod($left, $right);
                $perms = $reflection->getParameters();
                $className = $perms[0]->getType()->getName();

                if($className == "Psr\Http\Message\ServerRequestInterface"){
                    return $callable($request, $response, $routeArguments);
                }

                $headers = \Slim\Psr7\Headers::createFromGlobals();
                $headers->setHeaders($request->getHeaders());

                $castedObject = new $className(
                    $request->getMethod(),
                    $request->getUri(),
                    $headers,
                    $request->getCookieParams(),
                    $request->getServerParams(),
                    $request->getBody(),
                    $request->getUploadedFiles()
                );    
               
                $castedObject = $castedObject->withParsedBody( $request->getParsedBody());
                $castedObject->formBody();
                return $callable($castedObject, $response, $routeArguments);
            }        
        }
      
        return $callable($request, $response, $routeArguments);
    }
}