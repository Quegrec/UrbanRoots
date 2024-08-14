<?php

namespace Domain\Port\Repository;

use Domain\Entity\Module;

interface ModuleRepositoryInterface
{
    public function create(Module $module): Module;
    public function update(Module $module): Module;
    public function delete(string $id): bool;
    public function findAll(): array;
    public function findById(string $id): ?Module;
    public function findByStatus(string $status): array;
}