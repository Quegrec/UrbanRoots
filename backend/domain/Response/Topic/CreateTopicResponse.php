<?php

namespace Domain\Response\Topic;

use Domain\Entity\Topic;
use Domain\Response\DomainResponseInterface;

class CreateTopicResponse implements DomainResponseInterface
{
    public function __construct(
        private bool $success,
        private array $errors = [],
        private ?Topic $topic = null
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

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }
}