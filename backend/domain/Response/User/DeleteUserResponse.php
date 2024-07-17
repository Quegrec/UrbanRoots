<?php

namespace Domain\Response\User;

class DeleteUserResponse
{
    public function __construct(
        private bool $success,
        private array $errors = []
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
}