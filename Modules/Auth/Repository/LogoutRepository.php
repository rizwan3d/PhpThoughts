<?php

namespace App\Auth\Repository;

use App\Auth\Domain\Entities\BlacklistToken;
use App\Auth\Repository\Interface\LogoutRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;

/**
 * Summary of LogoutRepository
 */
class LogoutRepository implements LogoutRepositoryInterface
{
    /**
     * Summary of __construct
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Summary of logout
     * @param mixed $token
     * @return bool
     */
    public function logout($token) : bool{
        try{
        $newToken = new BlacklistToken($token);

        $this->em->persist($newToken);
        $this->em->flush();
        }
        catch(\Exception $e)
        {
            return false;
        }
        return true;
    }

    /**
     * Summary of isBlacklisted
     * @param mixed $token
     * @return bool
     */
    public function isBlacklisted($token): bool
    {
        $data = $this->em
        ->getRepository(BlacklistToken::class)
        ->findBy([ 'token' => $token]);

        if(count($data) > 0)
            return true;

        return false;
    }
}
