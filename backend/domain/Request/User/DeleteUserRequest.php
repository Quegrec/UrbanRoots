<?php

namespace Domain\Request\User;

class DeleteUserRequest
{
    public function __construct(
        private string $id
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}