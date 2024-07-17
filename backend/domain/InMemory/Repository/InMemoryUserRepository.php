<?php

namespace Domain\InMemory\Repository;

use Domain\Entity\User;
use Domain\Port\Repository\UserRepositoryInterface;

class InMemoryUserRepository implements UserRepositoryInterface
{
    private array $users = [];

    public function findAll(): array
    {
        return $this->users;
    }

    public function findById(string $id): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }

        return null;
    }

    public function findByUsername(string $username): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }

        return null;
    }

    public function findByEmail(string $email): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }

        return null;
    }

    public function create(User $user): User
    {
        $this->users[] = $user;

        return $user;
    }

    public function update(User $user): User
    {
        foreach ($this->users as $key => $value) {
            if ($value->getId() === $user->getId()) {
                $this->users[$key] = $user;
            }
        }

        return $user;
    }

    public function delete(string $id): bool
    {
        foreach ($this->users as $key => $value) {
            if ($value->getId() === $id) {
                unset($this->users[$key]);

                return true;
            }
        }

        return false;
    }
}