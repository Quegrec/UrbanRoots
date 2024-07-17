<?php

namespace Domain\Response\User;

use Domain\Response\DomainResponseInterface;
use Domain\Entity\UserRating;

class RateUserResponse implements DomainResponseInterface
{
    public function __construct(
        private bool $success,
        private array $errors = [],
        private ?UserRating $UserRating = null
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

    public function getUserRating(): ?UserRating
    {
        return $this->UserRating;
    }
}