<?php

namespace Domain\Response\Topic;

use Domain\Entity\Topic;
use Domain\Response\DomainResponseInterface;

class FindTopicResponse implements DomainResponseInterface
{
    public function __construct(
        private bool $success,
        private array $errors = [],
        private array $topics = []
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

    public function getTopics(): array
    {
        return $this->topics;
    }
}