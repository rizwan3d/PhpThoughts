<?php

namespace App\Auth\Repository;

use App\Auth\Repository\Interface\UserRepositoryInterface;
use App\Auth\Domain\Entities\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Func;

class UserRepository implements  UserRepositoryInterface {

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function persistUser($email) : ?User{
        $newUser = new User("ok@OK.COM");

        $this->em->persist($newUser);
        $this->em->flush();

        return $newUser;
    }


    public function getUsers() : ?array{
        $users = $this->em
            ->getRepository(User::class)
            ->findAll();
        return $users;
    }
}