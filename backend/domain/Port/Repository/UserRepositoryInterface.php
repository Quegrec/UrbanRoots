<?php

namespace Domain\Port\Repository;

use Domain\Entity\User;

interface UserRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): ?User;
    public function findByUsername(string $username): ?User;
    public function findByEmail(string $email): ?User;
    public function create(User $user): User;
    public function update(User $user): User;
    public function delete(string $id): bool;
}