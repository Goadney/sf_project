<?php

namespace App\Test\Fixtures;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashPasswordProvider
{

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function hashPassword(string $password): string
    {
        return $this->hasher->hashPassword(new User, $password);
    }
}
