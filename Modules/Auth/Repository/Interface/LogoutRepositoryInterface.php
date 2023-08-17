<?php

namespace App\Auth\Repository\Interface;

interface LogoutRepositoryInterface
{
    public function logout($token): bool;

    public function isBlacklisted($token): bool;
}
