<?php

namespace Domain\Port\Repository;

use Domain\Entity\Profile;

interface ProfileRepositoryInterface
{
    public function create(Profile $profile): Profile;
    public function update(Profile $profile): Profile;
    public function delete(string $id): bool;
    public function findById(string $id): ?Profile;
    public function findByUserId(string $userId): ?Profile;
}