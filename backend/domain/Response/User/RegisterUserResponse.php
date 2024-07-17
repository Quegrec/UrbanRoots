<?php

namespace Domain\Response\User;

use Domain\Entity\User;
use Domain\Response\DomainResponseInterface;

class RegisterUserResponse
{
    public function __construct(
        private bool $success,
        private array $errors = [],
        private ?User $user = null
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}