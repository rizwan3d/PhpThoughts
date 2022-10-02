<?php

namespace App\Auth\Repository;

use App\Auth\Repository\Interface\UserRepositoryInterface;
use App\Auth\Domain\Entities\User;

class UserRepository implements  UserRepositoryInterface {
    public function getUserById($id) : ?User{
        return null;
    }
}