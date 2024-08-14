<?php

namespace InMemory\Repository;

use Domain\Entity\Module;
use Domain\Port\Repository\ModuleRepositoryInterface;

class InMemoryModuleRepository implements ModuleRepositoryInterface
{
    private array $modules = [];

    public function create(Module $module): Module
    {
        $this->modules[$module->getId()] = $module;

        return $module;
    }

    public function update(Module $module): Module
    {
        $this->modules[$module->getId()] = $module;

        return $module;
    }

    public function delete(string $id): bool
    {
        if (isset($this->modules[$id])) {
            unset($this->modules[$id]);

            return true;
        }

        return false;
    }

    public function findAll(): array
    {
        return $this->modules;
    }

    public function findById(string $id): ?Module
    {
        return $this->modules[$id] ?? null;
    }

    public function findByStatus(string $status): array
    {
        return array_filter($this->modules, fn (Module $module) => $module->getStatus() === $status);
    }
}