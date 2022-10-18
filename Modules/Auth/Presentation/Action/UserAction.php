<?php

namespace App\Auth\Presentation\Action;

use App\Auth\Presentation\Middleware\AuthMiddleware;
use App\Auth\Services\AuthService;
use App\Framework\Action;
use App\Framework\RouteLoader\Attributes\Route;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

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
