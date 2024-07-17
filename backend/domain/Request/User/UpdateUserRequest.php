<?php

namespace Domain\Request\User;

class UpdateUserRequest
{
    public function __construct(
        private string $id,
        private ?string $username = null,
        private ?string $email = null,
        private ?string $password = null,
        private array $role = [] // This option is only available for admin users and should be handled in a separate use case ?
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRole(): array
    {
        return $this->role;
    }
}