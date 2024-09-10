<?php

namespace Domain\Request\User\Module;

class CreateModuleRequest
{
    public function __construct(
        private string $title,
        private string $content,
        private string $createdBy
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }
}