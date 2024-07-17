<?php

namespace Domain\Request\User;

class RateUserRequest
{
    public function __construct(
        private string $raterId,
        private string $rateeId,
        // private int $rating, // 1 to 5 (to be discussed)
        private string $comment
    ) {
    }

    public function getRaterId(): string
    {
        return $this->raterId;
    }

    public function getRateeId(): string
    {
        return $this->rateeId;
    }

    // public function getRating(): int
    // {
    //     return $this->rating;
    // }

    public function getComment(): string
    {
        return $this->comment;
    }
}