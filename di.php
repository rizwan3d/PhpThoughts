<?php

use App\Auth\Repository\Interface\LogoutRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Auth\Services\Interface\AuthServiceInterface;
use App\Auth\Repository\Interface\UserRepositoryInterface;
use App\Auth\Services\AuthService;
use App\Auth\Repository\UserRepository;
use App\Auth\Repository\LogoutRepository;

return [
    LogoutRepositoryInterface::class => DI\get(LogoutRepository::class),
    UserRepositoryInterface::class => DI\get(UserRepository::class),
    AuthServiceInterface::class => DI\get(AuthService::class),
];

