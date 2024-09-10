<?php

namespace Domain\DataMapper;

class TopicMapper implements DataMapperInterface
{
    public static function toSymfonyEntity($entity, $infraEntity = null)
    {
        if (is_null($infraEntity)) {
            $infraEntity = new \App\Entity\Topic();
        }

        $infraEntity 
            ->setId($entity->getId())
            ->setTitle($entity->getTitle())
            ->setDescription($entity->getDescription())
            // ->setAuthor($entity->getAuthorId())
            ->setCreatedAt($entity->getCreatedAt());

        if ($entity->getAuthorId() !== null) {
            $infraEntity->setAuthor(UserMapper::toSymfonyEntity($entity->getAuthor()));
        }

        return $infraEntity;
    }
    
    public static function toDomainEntity($entity, $infraEntity = null)
    {
        $infraEntity = (new \Domain\Entity\Topic(
            title: $entity->getTitle(),
            description: $entity->getDescription(),
            // authorId: $entity->getAuthor()->getId(),
        ))->setId($entity->getId())
            ->setCreatedAt($entity->getCreatedAt());

        return $infraEntity;
    }
}