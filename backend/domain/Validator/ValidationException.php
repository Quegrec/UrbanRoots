<?php

namespace Domain\Validator;

class ValidationException extends \Exception
{
    public function __construct(
        private array $errors
    ) {
        parent::__construct('Validation failed: ' . implode(', ', $errors), 0, null);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
