<?php

namespace App\Auth\Domain\Entities;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @OA\Schema(
 *     title="User",
 *     description="A user model."
 * )
 */
#[Entity, Table(name: 'users')]
final class User
{
    /**
     * @OA\Property(
     *   property="id",
     *   type="integer", 
     *   format="int64", 
     *   readOnly=true, 
     *   description="The user id",
     *   example=1
     * )
     */
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    public int $id;

    /**
     * @OA\Property(
     *   property="email",
     *   type="string",
     *   description="The user's email address",
     *   example="user@example.com"
     * )
     */
    #[Column(type: 'string', unique: true, nullable: false)]
    public string $email;

    /**
     * The user name
     * @var string
     *
     * @OA\Property(
     *   property="name",
     *   type="string",
     *   description="The user name",
     *   example="johndoe"
     * )
     */
    #[Column(type: 'string', nullable: true)]
    public string $name;

    /**
     * @OA\Property(
     *   property="password",
     *   type="string",
     *   description="The user's password hash"
     * )
     */
    #[Column(type: 'string', nullable: true)]
    public string $password;

    /**
     * @var string
     */
    public string $token;

    /**
     * @OA\Property(
     *   property="registered_at",
     *   type="string",
     *   format="date-time",
     *   readOnly=true,
     *   description="The registration date and time",
     *   example="2023-08-21T12:34:56Z"
     * )
     */
    #[Column(name: 'registered_at', type: 'datetimetz_immutable', nullable: false)]
    public DateTimeImmutable $registeredAt;

    public function __construct(string $email)
    {
        $this->email = $email;
        $this->registeredAt = new DateTimeImmutable('now');
    }
}
