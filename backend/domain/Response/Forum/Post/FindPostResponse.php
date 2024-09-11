<?php

namespace Domain\Response\Forum\Post;

use App\Entity\Post;

class FindPostResponse
{
    public function __construct(
        private bool $success,
        private array $errors = [],
        private array $posts = [],
        private ?Post $post = null
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

    public function getPosts(): ?array
    {
        return $this->posts;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }
}