<?php

namespace Domain\Request\Forum\Post;

class FindPostRequest
{
    public function __construct(
        private string $topicId,
    ) {
    }

    public function getTopicId(): string
    {
        return $this->topicId;
    }
}