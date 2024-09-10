<?php

namespace Domain\Port\Repository;

use Domain\Entity\Post;

interface PostRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): ?Post;
    public function findByTopicId(string $topicId): array;
    public function findByParentId(string $parentId): array;
    public function create(Post $post): Post;
    public function update(Post $post): Post;
    public function delete(string $id): bool;
}