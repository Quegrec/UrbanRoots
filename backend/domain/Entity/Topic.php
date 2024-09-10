<?php

namespace Domain\Entity;

class Topic
{
    private string $id;
    private \DateTimeInterface $createdAt;
    
    public function __construct(
        private string $title,
        private ?string $description = null,
        private ?string $authorId = null // Need to decide if usefull
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

    public function setId( string $id ): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle( string $title ): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription( ?string $description ): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthorId(): ?string
    {
        return $this->authorId;
    }

    public function setAuthorId( ?string $authorId ): self
    {
        $this->authorId = $authorId;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt( \DateTimeInterface $createdAt ): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}