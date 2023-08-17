<?php

namespace App\Auth\Presentation\Action;

use App\Auth\Services\AuthService;
use GrowBitTech\Framework\Action;
use GrowBitTech\Framework\Factory\LoggerFactory;
use GrowBitTech\Framework\Middleware\ValidationMiddleware;
use GrowBitTech\Framework\RouteLoader\Attributes\Route;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;

/**
 * @OA\Post(
 *     path="/login",
 *     tags={"login"},
 *     summary="Login user",
 *     description=".",
 *     operationId="loginUser",
 *
 *     @OA\Response(
 *         response="default",
 *         description="successful operation"
 *     ),
 *
 *     @OA\RequestBody(
 *         description="Login user object",
 *         required=true,
 *     )
 * )
 */
final class LoginAction extends Action
{
    public static $validations = [
        'email'    => 'required|email',
        'password' => 'required',
    ];

    private AuthService $authService;

    private LoggerInterface $logger;

    public function __construct(AuthService $authService,LoggerFactory $loggerFactory)
    {
        $this->authService = $authService;
        $this->logger = $loggerFactory->addFileHandler(static::class)->createLogger();
    }

    #[Route('/login', ['POST'], ValidationMiddleware::class)]
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $data = (array) $request->getParsedBody();

        $this->logger->info('Called Auth servie');

        $reuslt = $this->authService->loginUser($data['email'], $data['password']);

        return $this->success($response, ['msg' => 'ok', 'data' => $reuslt]);
    }
}
