<?php

namespace GrowBitTech\Framework\Swagger;

use GrowBitTech\Framework\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class SwaggerYaml extends Action
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        error_reporting(0);

        $openapi = \OpenApi\Generator::scan([__DIR__.'/../../Modules']);

        $response->getBody()->write($openapi->toYaml());

        return $response
            ->withHeader('content-type', 'application/x-yaml')
            ->withStatus(200);
    }
}
