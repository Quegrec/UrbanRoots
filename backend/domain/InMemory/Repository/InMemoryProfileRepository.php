<?php

namespace Domain\InMemory\Repository;

use Domain\Entity\Profile;
use Domain\Port\Repository\ProfileRepositoryInterface;

class InMemoryProfileRepository implements ProfileRepositoryInterface
{
    private array $profiles = [];

    public function create(Profile $profile): Profile
    {
        $this->profiles[] = $profile;

        return $profile;
    }

    public function update(Profile $profile): Profile
    {
        foreach ($this->profiles as $key => $value) {
            if ($value->getId() === $profile->getId()) {
                $this->profiles[$key] = $profile;
            }
        }

        return $profile;
    }

    public function delete(string $id): bool
    {
        foreach ($this->profiles as $key => $value) {
            if ($value->getId() === $id) {
                unset($this->profiles[$key]);

                return true;
            }
        }

        return false;
    }

    public function findById(string $id): ?Profile
    {
        foreach ($this->profiles as $profile) {
            if ($profile->getId() === $id) {
                return $profile;
            }
        }

        return null;
    }

    public function findByUserId(string $userId): ?Profile
    {
        foreach ($this->profiles as $profile) {
            if ($profile->getUser()->getId() === $userId) {
                return $profile;
            }
        }

        return null;
    }
}