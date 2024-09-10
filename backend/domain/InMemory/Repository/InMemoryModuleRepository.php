<?php

namespace Domain\InMemory\Repository;

use Domain\Entity\Module;
use Domain\Port\Repository\ModuleRepositoryInterface;

class InMemoryModuleRepository implements ModuleRepositoryInterface
{
    private $modules = [];

    public function create(Module $module): Module
    {
        $this->modules[] = $module;

        return $module;
    }

    public function update(Module $module): Module
    {
        foreach ($this->modules as $key => $value) {
            if ($value->getId() === $module->getId()) {
                $this->modules[$key] = $module;
            }
        }

        return $module;
    }

    public function delete(string $id): bool
    {
        foreach ($this->modules as $key => $value) {
            if ($value->getId() === $id) {
                unset($this->modules[$key]);

                return true;
            }
        }

        return false;
    }

    public function findById(string $id): ?Module
    {
        foreach ($this->modules as $module) {
            if ($module->getId() === $id) {
                return $module;
            }
        }

        return null;
    }

    public function findByCreator(string $userId): ?Module
    {
        foreach ($this->modules as $module) {
            if ($module->getCreatedBy()->getId() === $userId) {
                return $module;
            }
        }

        return null;
    }
}