<?php

namespace Domain\Response\User;

use Domain\Response\DomainResponseInterface;

class LoginUserResponse implements DomainResponseInterface
{
    public function __construct(
        private bool $success,
        private array $errors = [],
        private ?string $token = null
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

    public function getToken(): ?string
    {
        return $this->token;
    }
}