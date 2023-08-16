<?php

namespace App\Auth\Services;

use App\Auth\Domain\Entities\User;
use App\Auth\Repository\UserRepository;
use Firebase\JWT\JWT;
use GrowBitTech\Framework\Config\_Global;

class AuthService
{
    private UserRepository $userRepository;
    private _Global $globel;
    private User $user;

    public function __construct(UserRepository $userRepository, _Global $globel)
    {
        $this->userRepository = $userRepository;
        $this->globel = $globel;
    }

    public function findUser($email): ?User
    {
        return $this->userRepository->findUser(['email' => $email]);
    }

    public function loginUser($email, $password): User|array
    {
        $user = $this->findUser($email);
        if ($user && $this->verifyPassword($user, $password)) {
            $result = $this->getJWT($user);
            $user->token = $result;
            $this->setUser($user);

            return $user;
        }

        return ['error' => ['user name or password is invalid']];
    }

    public function getJWT($user)
    {
        $token = [
            'iat'  => time(),
            'exp'  => time() + 2592000,
            'data' => [
                'time'    => time(),
                'user_id' => $user->id,
            ],
        ];

        return JWT::encode($token, $this->globel->get('authkey'), 'HS256');
    }

    public function getAllUser(): ?array
    {
        $users = $this->userRepository->getUsers();

        return $users;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($user, $password)
    {
        return password_verify($password, $user->password);
    }
}
