<?php

namespace Domain\Validator;

class ValidationResult
{
    public function __construct(
        private bool $isValid,
        private array $errors
    ) {
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
