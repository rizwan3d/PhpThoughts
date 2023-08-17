<?php

namespace App\Auth\Domain\Entities;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'blacklist_token')]
final class BlacklistToken
{
    #[Id,Column(type: 'string', unique: true, nullable: false)]
    public string $token;

    #[Column(name: 'created_at', type: 'datetimetz_immutable', nullable: false)]
    public DateTimeImmutable $createdAt;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->createdAt = new DateTimeImmutable('now');
    }
}
