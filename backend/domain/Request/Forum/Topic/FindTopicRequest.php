<?php

namespace Domain\Request\Forum\Topic;

class FindTopicRequest
{
    public function __construct(
        private ?string $title = null,
    ) {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
}