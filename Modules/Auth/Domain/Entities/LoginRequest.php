<?php

namespace App\Auth\Domain\Entities;

use GrowBitTech\Framework\Request;

/**
 * @OA\Schema(
 *     title="LoginRequest",
 *     description="A LoginRequest model."
 * )
 */
final class LoginRequest extends Request
{
    /**
     * @OA\Property(
     *   property="email",
     *   type="string",
     *   description="The user's email address",
     *   example="user@example.com"
     * )
     */
    public string $email;

    /**
     * @OA\Property(
     *   property="password",
     *   type="string",
     *   description="The user's password hash"
     * )
     */
    public string $password;
}
