<?php

namespace Domain\Entity;

class UserRating
{
    private string $id;
    public function __construct(
        private User $rater,
        private User $ratee,
        // private int $rating, // 1 to 5 (to be discussed)
        private string $comment,
        private \DateTimeInterface $createdAt
    ) {
        if (empty($this->id)) {
            $this->id = uniqid();
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRater(): User
    {
        return $this->rater;
    }

    public function setRater(User $rater): self
    {
        $this->rater = $rater;

        return $this;
    }

    public function getRatee(): User
    {
        return $this->ratee;
    }

    public function setRatee(User $ratee): self
    {
        $this->ratee = $ratee;

        return $this;
    }

    // public function getRating(): int
    // {
    //     return $this->rating;
    // }

    // public function setRating(int $rating): self
    // {
    //     $this->rating = $rating;
    
    //     return $this;
    // }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
    