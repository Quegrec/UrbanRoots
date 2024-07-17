<?php

namespace Domain\Validator\Entity;

use Domain\Validator\ValidationResult;
use Domain\Validator\ValidatorInterface;

class UserValidator implements ValidatorInterface
{
    public function validate($request): ValidationResult
    {
        $errors = [];

        if (empty($request->getUsername())) {
            $errors['username'] = 'Username is required';
        } elseif (strlen($request->getUsername()) < 3) {
            $errors['username'] = 'Username must be at least 3 characters';
        }

        if (empty($request->getEmail())) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($request->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        if (empty($request->getPassword())) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($request->getPassword()) < 8) {
            $errors['password'] = 'Password must be at least 8 characters';
        }

        return new ValidationResult(
            empty($errors),
            $errors
        );
    }
}