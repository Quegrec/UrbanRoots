<?php

namespace Domain\Entity;

class Post
{
    private string $id;
    private \DateTimeInterface $createdAt;
    private ?\DateTimeInterface $updatedAt;
    private bool $isDeleted = false; // Soft delete (I don't know how i should handle this)
    private ?string $parentId = null; // In case of responding to an existing post


    public function __construct(
        private string $content,
        private string $postId,
        private string $authorId,
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

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent( string $content ): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPostId(): string
    {
        return $this->postId;
    }

    public function setPostId( string $postId ): self
    {
        $this->postId = $postId;

        return $this;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function setAuthorId( string $authorId ): self
    {
        $this->authorId = $authorId;

        return $this;
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function setParentId( ?string $parentId ): self
    {
        $this->parentId = $parentId;

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

    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted( bool $isDeleted ): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }
}