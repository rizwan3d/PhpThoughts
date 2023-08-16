<?php

namespace GrowBitTech\Framework\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Rakit\Validation\Validator;
use Slim\Psr7\Response;

class ValidationMiddleware
{
    private $rules = [];
    private $validator;

    public function __construct($rules = [])
    {
        $this->rules = $rules;
        $this->validator = new Validator();
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $data = (array) $request->getParsedBody();
        $validation = $this->validator->validate($data, $this->rules);

        if ($validation->fails()) {
            $error = [
                'error' => [$validation->errors()->firstOfAll()],
            ];
            $response = new Response();
            $response->getBody()->write(json_encode($error, JSON_UNESCAPED_UNICODE));

            return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(403);
        }

        return $handler->handle($request);
    }
}
