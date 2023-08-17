<?php

namespace App\Auth\Services;

use App\Auth\Domain\Entities\User;
use App\Auth\Repository\UserRepository;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GrowBitTech\Framework\Config\_Global;

class AuthService
{
    private UserRepository $userRepository;
    private _Global $globel;
    private User $user;

    public function __construct(UserRepository $userRepository,_Global $globel)
    {
        $this->userRepository = $userRepository;
        $this->globel = $globel;
    }
    public function findUser($where) : ?User{
        return $this->userRepository->findUser($where);
    }

    public function loginUser($email,$password) : User | array{
        $user = $this->findUser([ 'email' => $email]);
        if ($user && $this->verifyPassword($user,$password)){
             $result = $this->getJWT($user);
             $user->token = $result;
             $this->setUser($user);
             return $user;
        }
        return [ 'error' => [ 'user name or password is invalid' ]];
    }

    public function verifyJWT($token) : User | array {
        try {
            $decoded = JWT::decode($token, new Key($this->globel->get('authkey'), 'HS256'));
            
            $now = new DateTimeImmutable();
            if ($decoded->iat > $now->getTimestamp() ||
                $decoded->exp < $now->getTimestamp())
                return ['error' => 'Invalid Token.'];

            $user = $this->findUser([ 'id' => $decoded->data->user_id]);
            if ($user) {
                $this->setUser($user);
                return $user;
            } else {
                return ['error' => 'Invalid Token.'];
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getJWT($user){
		$token = [
			"iat" => time(),
			"exp" => time() + 2592000,
			"data" => [
                "time" => time(),
				"user_id" => $user->id
			]
		];
		return JWT::encode($token, $this->globel->get('authkey'), 'HS256');
	}

    public function getAllUser(): ?array
    {
        $users = $this->userRepository->getUsers();

        return $users;
    }

    public function setUser(User $user){
        $this->user = $user;
    }

    public function getUser(){
    	return $this->user;
    }

    public function hash($password){
     	return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($user,$password){
    	return password_verify($password, $user->password);
    }
}
