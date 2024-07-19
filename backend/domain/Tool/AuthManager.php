<?php

namespace Domain\Tool;

class AuthManager
{
    public function __construct(
        private string $password
    ) {
    }

    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    public static function generateId(): string
    {
        return uniqid();
    }
}