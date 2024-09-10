<?php

namespace Domain\DataMapper;

class UserMapper implements DataMapperInterface
{
    public static function toSymfonyEntity($entity)
    {
        $infraEntity = (new \App\Entity\User())
            ->setId($entity->getId())
            ->setUsername($entity->getUsername())
            ->setEmail($entity->getEmail())
            ->setPassword($entity->getPassword())
            ->setCreatedAt($entity->getCreatedAt())
            ->setRoles($entity->getRole());

        return $infraEntity;
    }

    public static function toDomainEntity($entity)
    {
        $infraEntity = (new \Domain\Entity\User(
            username: $entity->getUsername(),
            email: $entity->getEmail(),
            password: $entity->getPassword(),
            role: $entity->getRoles(),
        ))->setId($entity->getId())
            ->setCreatedAt($entity->getCreatedAt());

        return $infraEntity;
    }
}