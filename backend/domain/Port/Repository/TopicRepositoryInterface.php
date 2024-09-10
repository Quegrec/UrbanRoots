<?php

namespace Domain\Port\Repository;

use Domain\Entity\Topic;

interface TopicRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): ?Topic;
    public function findByTitle(string $title): ?Topic;
    public function create(Topic $topic): Topic;
    public function delete(string $id): bool;
}