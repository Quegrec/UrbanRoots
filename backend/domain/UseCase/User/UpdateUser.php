<?php

namespace Domain\UseCase\User;

use Domain\Definition\ErrorStatus;
use Domain\Port\Repository\UserRepositoryInterface;
use Domain\Request\User\UpdateUserRequest;
use Domain\Response\User\UpdateUserResponse;
use Domain\UseCase\UseCase;
use Domain\Validator\Entity\UserValidator;
use Domain\Validator\ValidationException;

class UpdateUser extends UseCase
{
    public function __construct(
        UserValidator $validator,
        private UserRepositoryInterface $userRepository
    ) {
        parent::__construct($validator);
    }

    public function execute(UpdateUserRequest $request): UpdateUserResponse
    {
        try {
            $this->validate($request);
        } catch (ValidationException $e) {
            return new UpdateUserResponse(success: false, errors: [ErrorStatus::BAD_REQUEST => $e->getMessage()]);
        }

        $user = $this->userRepository->findById($request->getId());

        if (!$user) {
            return new UpdateUserResponse(success: false, errors: [ErrorStatus::NOT_FOUND => 'User not found']);
        }
        
        if (!empty($request->getUsername())) {
            if ($this->userRepository->findByUsername($request->getUsername())) {
                return new UpdateUserResponse(success: false, errors: [ErrorStatus::BAD_REQUEST => 'Username already exists']);
            }
            $user->setUsername($request->getUsername());
        }

        if (!empty($request->getEmail())) {
            if ($this->userRepository->findByEmail($request->getEmail())) {
                return new UpdateUserResponse(success: false, errors: [ErrorStatus::BAD_REQUEST => 'Email already exists']);
            }
            $user->setEmail($request->getEmail());
        }

        if (!empty($request->getPassword())) {
            $user->setPassword(password_hash($request->getPassword(), PASSWORD_DEFAULT));
        }

        // This option is only available for admin users and should be handled in a separate use case ?
        if (!empty($request->getRole())) {
            $user->setRole($request->getRole());
        }

        try {
            $this->userRepository->update($user);
        } catch (\Exception $e) {
            return new UpdateUserResponse(success: false, errors: [ErrorStatus::INTERNAL_ERROR => $e->getMessage()]);
        }

        return new UpdateUserResponse(success: true, user: $user);
    }
}