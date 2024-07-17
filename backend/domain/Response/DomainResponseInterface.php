<?php

namespace Domain\Response;

interface DomainResponseInterface
{
    public function isSuccess(): bool;

    public function getErrors(): array;
}
