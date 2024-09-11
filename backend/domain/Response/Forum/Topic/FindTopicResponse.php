<?php

namespace Domain\Response\Forum\Topic;

use Domain\Entity\Topic;
use Domain\Response\DomainResponseInterface;

class FindTopicResponse implements DomainResponseInterface
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