<?php

namespace App\Auth\Repository\Interface;

use App\Auth\Domain\Entities\User;

interface UserRepositoryInterface {
    public function getUserById($id) : ?User;
}