<?php

namespace App\Auth\Repository;

use App\Auth\Domain\Entities\User;
use App\Auth\Repository\Interface\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findUser($where): ?User
    {
        $data = $this->em
        ->getRepository(User::class)
        ->findBy($where);

        if (count($data) > 0) {
            return $data[0];
        }

        return null;
    }

    public function persistUser($email): ?User
    {
        $newUser = new User('ok@OK.COM');

        $this->em->persist($newUser);
        $this->em->flush();

        return $newUser;
    }

    public function getUsers(): ?array
    {
        $users = $this->em
            ->getRepository(User::class)
            ->findAll();

        return $users;
    }
}
