<?php

namespace Domain\Response\Module;

use Domain\Entity\Module;
use Domain\Response\DomainResponseInterface;

class CreateModuleResponse implements DomainResponseInterface
{
    public function __construct(
        private bool $success,
        private array $errors = [],
        private ?Module $module = null
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

    public function getModule(): ?Module
    {
        return $this->module;
    }
}