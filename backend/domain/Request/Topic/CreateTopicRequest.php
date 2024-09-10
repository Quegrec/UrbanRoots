<?php

namespace Domain\Request\Topic;

class CreateTopicRequest
{
    public function __construct(
        private string $title,
        private ?string $description = null,
        private ?string $createdBy = null
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }
}