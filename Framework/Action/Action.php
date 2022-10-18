<?php

namespace App\Framework;

use Psr\Http\Message\ResponseInterface as Response;
use Rakit\Validation\Validator;

class Action
{
    public function __construct()
    {
        $this->validator = new Validator();
    }

    protected function validate($data, $rules)
    {
        $validation = $this->validator->validate($data, $rules);

        if ($validation->fails()) {
            $error = $validation->errors()->firstOfAll();

            return $error;
        }

        return false;
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
