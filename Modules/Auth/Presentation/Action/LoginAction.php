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
 *     tags={"User"},
 *     summary="Login user",
 *     description="Logs in a user by providing email and password.",
 *     operationId="loginUser",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="User name or password is invalid",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="error", type="array", @OA\Items(type="string"))
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="error", type="array", @OA\Items(type="string"))
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="User email and password",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="email", type="string"),
 *                 @OA\Property(property="password", type="string"),
 *                 example={"email": "example@ok.com", "password": "password"}
 *             )
 *         )
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

    /**
     * Endpoint for handling the login action
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param mixed $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[Route('/login', ['POST'], ValidationMiddleware::class)]
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $data = (array) $request->getParsedBody();

        $this->logger->info('Called Auth servie');

        $reuslt = $this->authService->loginUser($data['email'], $data['password']);

        if(is_array($reuslt) && isset($reuslt['error'])){
            $this->logger->error('Login failed', ['error' => $reuslt['error']]);
            return $this->notFound($response, $reuslt);
        }

        $this->logger->info('Login successful', ['user_id' => $reuslt->id]);
        return $this->success($response, ['status' => 'success', 'data' => $reuslt]);
    }
}
