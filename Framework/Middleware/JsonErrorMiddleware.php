<?php

namespace GrowBitTech\Framework\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

class JsonErrorMiddleware
{
    public function __invoke(Request $request, \Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails, ?LoggerInterface $logger = null)
    {
        $payload = ['error' => $exception->getMessage()];

        $response = new Response();
        $response->getBody()
            ->write(json_encode($payload, JSON_UNESCAPED_UNICODE));

        return $response;
    }
}
