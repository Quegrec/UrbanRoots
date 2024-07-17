<?php

namespace Domain\Request\User;

class RegisterUserRequest
{
    public function __construct(
        private string $username,
        private string $email,
        private string $password,
        private array $role = ['ROLE_USER']
    ) {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): array
    {
        return $this->role;
    }
}