<?php

use App\Auth\Repository\Interface\LogoutRepositoryInterface;
use App\Auth\Repository\Interface\UserRepositoryInterface;
use App\Auth\Repository\LogoutRepository;
use App\Auth\Repository\UserRepository;
use App\Auth\Services\AuthService;
use App\Auth\Services\Interface\AuthServiceInterface;

return [
    LogoutRepositoryInterface::class => DI\get(LogoutRepository::class),
    UserRepositoryInterface::class   => DI\get(UserRepository::class),
    AuthServiceInterface::class      => DI\get(AuthService::class),
];
