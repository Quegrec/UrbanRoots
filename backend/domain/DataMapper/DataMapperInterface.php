<?php

namespace Domain\DataMapper;

interface DataMapperInterface
{
    public static function toSymfonyEntity($entity);

    public static function toDomainEntity($entity);
}
