<?php

namespace App\Auth\Presentation\Action;

use GrowBitTech\Framework\Middleware\ValidationMiddleware;
use App\Auth\Services\AuthService;
use GrowBitTech\Framework\Action;
use GrowBitTech\Framework\RouteLoader\Attributes\Route;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

/**
 * @OA\Post(
 *     path="/login",
 *     tags={"login"},
 *     summary="Login user",
 *     description=".",
 *     operationId="loginUser",
 *     @OA\Response(
 *         response="default",
 *         description="successful operation"
 *     ),
 *     @OA\RequestBody(
 *         description="Login user object",
 *         required=true,
 *     )
 * )
 */
final class LoginAction extends Action
{
    static $validations = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    #[Route('/login', ['POST'],ValidationMiddleware::class)]
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $data = (array)$request->getParsedBody();
        
        $reuslt = $this->authService->loginUser($data['email'],$data['password']);

        return $this->success($response, ['msg' => 'ok', 'data' => $reuslt]);
    }
}
