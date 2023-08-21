<?php

namespace App\Auth\Presentation\Middleware;

use App\Auth\Services\AuthService;
use App\Auth\Services\Interface\AuthServiceInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

/**
*  @OA\SecurityScheme(
*     type="http",
*     securityScheme="bearerAuth",
*     scheme= "bearer",
*     bearerFormat= "JWT",
* )
*/
class AuthMiddleware
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $header = $request->getHeaderLine('Authorization');

        if (false === empty($header)) {
            if (preg_match("/Bearer\s+(.*)$/i", $header, $matches)) {
                try {
                    $result = $this->authService->verifyJWT($matches[1]);
                    if(is_array($result))
                        return $this->error($result);
                    return $handler->handle($request);
                } catch (\Exception $e) {
                    return $this->error(['status' => 'error','error' => $e->getMessage()]);
                }
            } else {
                return $this->error(['status' => 'error','error' => ['Auth token cannot find.']]);
            }
        } else {
            return $this->error(['status' => 'error','error' => ['Auth token cannot find.']]);
        }
    }

    public function error($data)
    {
        $response = new Response();

        $response->getBody()->write(json_encode($data));
        $response = $response->withHeader('content-type', 'application/json')->withStatus(401);

        return $response;
    }
}
