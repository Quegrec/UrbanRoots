<?php

namespace Domain\DataMapper;

class ProfileMapper implements DataMapperInterface
{
    public static function toSymfonyEntity($entity, $infraEntity = null)
    {
        if (is_null($infraEntity)) {
            $infraEntity = new \App\Entity\Profile();
        }

        $infraEntity
            ->setId($entity->getId())
            ->setOwner($entity->getUser())
            ->setBio($entity->getBio());

        if ($entity->getOwner() !== null) {
            $infraEntity->setOwner(UserMapper::toSymfonyEntity($entity->getOwner()));
        }

        return $infraEntity;
    }

    public static function toDomainEntity($entity)
    {
        $infraEntity = (new \Domain\Entity\Profile(
            user: $entity->getUser(),
        ))->setId($entity->getId())
            ->setBio($entity->getBio())
            ->setAvatarUrl($entity->getAvatarUrl())
            ->setLocation($entity->getLocation());

        return $infraEntity;
    }
}