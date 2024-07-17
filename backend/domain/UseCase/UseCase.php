<?php

namespace Domain\UseCase;

use Domain\Validator\ValidatorInterface;
use Domain\Validator\ValidationException;

class UseCase
{
    public function __construct(
        protected ValidatorInterface $validator
    ) {
    }

    protected function validate($request): void
    {
        $validationResult = $this->validator->validate($request);
        if (!$validationResult->isValid()) {
            throw new ValidationException($validationResult->getErrors());
        }
    }
}
