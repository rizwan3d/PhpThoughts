<?php

namespace App\Auth\Presentation\Action;

use App\Auth\Presentation\Middleware\AuthMiddleware;
use App\Auth\Services\AuthService;
use GrowBitTech\Framework\Action;
use GrowBitTech\Framework\RouteLoader\Attributes\Route;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @OA\Get(
 *     path="/logout",
 *     tags={"logout"},
 *     summary="Logout user",
 *     description=".",
 *     operationId="LogoutUser",
 *     @OA\Response(
 *         response="default",
 *         description="successful operation"
 *     ),
 *     @OA\RequestBody(
 *         description="Logout user object",
 *         required=true,
 *     )
 * )
 */
final class LogoutAction extends Action
{
    /**
     * Summary of authService
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * Summary of __construct
     * @param \App\Auth\Services\AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    #[Route('/logout', ['GET'],AuthMiddleware::class)]
    /**
     * Summary of __invoke
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param mixed $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $header = $request->getHeaderLine('Authorization');

        if (false === empty($header)) {
            if (preg_match("/Bearer\s+(.*)$/i", $header, $matches)) {
                try {
                    $result = $this->authService->verifyJWT($matches[1]);
                    if(is_array($result))
                        return $this->error($response,$result);
                    if($this->authService->logout($matches[1]))
                        return $this->success($response,['data' => 'logout successfuly.']);;
                    return $this->error($response,['error' => 'Invalid Token.']);
                } catch (\Exception $e) {
                    return $this->error($response,['error' => $e->getMessage()]);
                }
            } else {
                return $this->error($response,['error' => 'Auth token cannot find.']);
            }
        } else {
            return $this->error($response,['error' => 'Auth token cannot find.']);
        }
    }
}
