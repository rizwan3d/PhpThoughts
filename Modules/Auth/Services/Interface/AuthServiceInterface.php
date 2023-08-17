<?php

namespace App\Auth\Services\Interface;

use App\Auth\Domain\Entities\User;

interface AuthServiceInterface
{
    public function findUser($where) : ?User;

    public function loginUser($email,$password) : User | array;

    public function logout($token) : bool;

    public function verifyJWT($token) : User | array;

    public function getJWT($user): string;

    public function getAllUser(): ?array;

    public function setUser(User $user);
    public function getUser() : User;

    public function hash($password): string;

    public function verifyPassword($user,$password): bool;
}
