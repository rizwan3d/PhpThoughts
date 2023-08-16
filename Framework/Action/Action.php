<?php

namespace GrowBitTech\Framework;

use Psr\Http\Message\ResponseInterface as Response;

class Action
{
    public function __construct()
    {
    }
       
    protected function success(Response $response, $data)
    {
        return $this->responce($response, $data, 200);
    }

    protected function responce(Response $response, $data, $code)
    {
        $response->getBody()->write(json_encode($data));

        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus($code);
    }

    protected function error(Response $response, $data)
    {
        $data = ['message' => $data];

        return $this->responce($response, $data, 500);
    }
}
