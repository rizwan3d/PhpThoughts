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
 *     path="/user",
 *     tags={"user"},
 *     summary="Create user",
 *     description="This can only be done by the logged in user.",
 *     operationId="createUser",
 *
 *     @OA\Response(
 *         response="default",
 *         description="successful operation"
 *     ),
 *
 *     @OA\RequestBody(
 *         description="Create user object",
 *         required=false,
 *     )
 * )
 */
final class UserAction extends Action
{
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    #[Route('/', ['GET'], AuthMiddleware::class)]
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $users = $this->authService->getAllUser();

        return $this->success($response, ['msg' => 'ok', 'data' => $users]);
    }
}
