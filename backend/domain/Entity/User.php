<?php

namespace Domain\Entity;

class User
{
    private string $id;
    private \DateTimeInterface $createdAt;
    private ?\DateTimeInterface $updatedAt = null;
    private ?\DateTimeInterface $lastConnection = null;
    private array $ratings = [];

    public function __construct(
        private string $username,
        private string $email,
        private string $password,
        private array $role
    ) {
        if (empty($this->id)) {
            $this->id = uniqid();
            $this->createdAt = new \DateTime();
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
    
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): self
    {
        $this->role = $role;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function addRating(UserRating $rating): self
    {
        $this->ratings[] = $rating;
        $this->updatedAt = new \DateTime();
        
        return $this;
    }

    public function getRatings(): array
    {
        return $this->ratings;
    }

        public function getLastConnection(): ?\DateTimeInterface
    {
        return $this->lastConnection;
    }

    public function login(): self
    {
        $this->lastConnection = new \DateTime();

        return $this;
    }
}