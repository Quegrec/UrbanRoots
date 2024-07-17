<?php

namespace Domain\Validator;

/**
 * Use this to validate data after creating an entity but before saving it to the database.
 * 
 * @method ValidationResult validate(array $data)
 */
interface ValidatorInterface
{
    // TODO: Add the correct type hint for $request
    public function validate(array $request): ValidationResult;
}
