<?php

namespace App\Auth\Presentation\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Auth\Domain\Entities\User;
use App\Auth\Services\AuthService;
use App\Framework\Action;
use App\Framework\RouteLoader\Attributes\Route;
use App\Auth\Presentation\Middleware\AuthMiddleware;

final class UserAction extends Action {

    function __construct(AuthService $authService) {
		$this->authService = $authService;
	}

    #[Route('/',['GET'],AuthMiddleware::class)]
    public function __invoke(Request $request, Response $response, $args): Response {    
        $users = $this->authService->getAllUser();
        return $this->success($response, ["msg" => "ok" , 'data' => $users]);
    }
}