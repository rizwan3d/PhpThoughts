<?php

namespace App\Auth\Presentation\Action;

use App\Auth\Presentation\Middleware\AuthMiddleware;
use App\Auth\Services\AuthService;
use App\Auth\Services\Interface\AuthServiceInterface;
use GrowBitTech\Framework\Action;
use GrowBitTech\Framework\Factory\LoggerFactory;
use GrowBitTech\Framework\RouteLoader\Attributes\Route;
use OpenApi\Annotations as OA;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;

/**
 * @OA\Get(
 *     path="/logout",
 *     tags={"User"},
 *     summary="Logout user",
 *     description="Logs out the user by invalidating the token.",
 *     operationId="LogoutUser",
 *     @OA\Response(
 *         response=200,
 *         description="Logout successful",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="array", @OA\Items(type="string", example="Logout successfully."))
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid Token",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="error", type="array", @OA\Items(type="string", example="Invalid Token."))
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Auth token cannot find",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="error", type="array", @OA\Items(type="string", example="Auth token cannot find."))
 *         )
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */

final class LogoutAction extends Action
{
    private AuthServiceInterface $authService;
    private LoggerInterface $logger;

    public function __construct(AuthServiceInterface $authService,LoggerFactory $loggerFactory)
    {
        $this->authService = $authService;
        $this->logger = $loggerFactory->addFileHandler(static::class)->createLogger();
    }

    /**
     * Endpoint for handling the logout action
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param mixed $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[Route('/logout', ['GET'],AuthMiddleware::class)]
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $header = $request->getHeaderLine('Authorization');

        preg_match("/Bearer\s+(.*)$/i", $header, $matches);
        if($this->authService->logout($matches[1])){
            $this->logger->info('Logout successful', ['token' => $matches[1]]);
            return $this->success($response,['status' => 'sucess','data' => ['logout successfuly.']]);
        }
        
        $this->logger->error('Logout failed', ['token' => $matches[1], 'error' => 'Invalid Token.']);
        return $this->responce($response,['status' => 'error','error' => ['Invalid Token.']],401);
    }
}
