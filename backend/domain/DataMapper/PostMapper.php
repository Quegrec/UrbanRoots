<?php

namespace Domain\DataMapper;

class PostMapper implements DataMapperInterface
{
    public static function toSymfonyEntity($entity, $infraEntity = null)
    {
        if (is_null($infraEntity)) {
            $infraEntity = new \App\Entity\Post();
        }

        $infraEntity
            ->setId($entity->getId())
            ->setContent($entity->getContent())
            ->setTopic($entity->getTopic())
            ->setAuthor($entity->getAuthor())
            ->setParent($entity->getParent())
            ->setCreatedAt($entity->getCreatedAt())
            ->setUpdatedAt($entity->getUpdatedAt());

        if ($entity->getTopic() !== null) {
            $infraEntity->setTopic(TopicMapper::toSymfonyEntity($entity->getTopic()));
        }
        if ($entity->getAuthor() !== null) {
            $infraEntity->setAuthor(UserMapper::toSymfonyEntity($entity->getAuthor()));
        }
        if ($entity->getParent() !== null) {
            $infraEntity->setParent(self::toSymfonyEntity($entity->getParent()));
        }

        return $infraEntity;
    }
    
    public static function toDomainEntity($entity)
    {
        $infraEntity = (new \Domain\Entity\Post(
            content: $entity->getContent(),
            postId: $entity->getId(),
            authorId: $entity->getAuthor()->getId()
        ))->setId($entity->getId())
            ->setCreatedAt($entity->getCreatedAt())
            ->setUpdatedAt($entity->getUpdatedAt())
            ->setParentId($entity->getParent() ? $entity->getParent()->getId() : null);

        return $infraEntity;
    }
}