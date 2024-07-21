<?php

namespace Domain\UseCase\User;

use Domain\Entity\User;
use Domain\Entity\Profile;
use Domain\UseCase\UseCase;
use Domain\Definition\ErrorStatus;
use Domain\Validator\ValidatorInterface;
use Domain\Validator\ValidationException;
use Domain\Request\User\RegisterUserRequest;
use Domain\Response\User\RegisterUserResponse;
use Domain\Port\Repository\UserRepositoryInterface;
use Domain\Port\Repository\ProfileRepositoryInterface;

class RegisterUser extends UseCase
{
    public function __construct(
        ValidatorInterface $validator,
        private UserRepositoryInterface $userRepository,
        private ProfileRepositoryInterface $profileRepository
    ) {
        parent::__construct($validator);
    }

    public function execute(RegisterUserRequest $request): RegisterUserResponse
    {
        try {
            $this->validate($request);
        } catch (ValidationException $e) {
            return new RegisterUserResponse(success: false, errors: [ErrorStatus::INVALID_PARAM => $e->getErrors()]);
        }
        
        if ($this->userRepository->findByEmail($request->getEmail())) {
            return new RegisterUserResponse(success: false, errors: [ErrorStatus::BAD_REQUEST => 'Email already in use']);
        }

        if ($this->userRepository->findByUsername($request->getUsername())) {
            return new RegisterUserResponse(success: false, errors: [ErrorStatus::BAD_REQUEST => 'Username taken']);
        }
           
        $user = new User(
            username: $request->getUsername(),
            email: $request->getEmail(),
            password: password_hash($request->getPassword(), PASSWORD_DEFAULT),
            role: $request->getRole()
        );

        $profile = new Profile(
            user: $user
        );
        // dump($profile);

        try {
            $this->userRepository->create($user);
            if ($request->getRole() !== ['ROLE_ADMIN']) {
                $this->profileRepository->create($profile);
            }
        } catch (\Exception $e) {
            return new RegisterUserResponse(success: false, errors: [ErrorStatus::INTERNAL_ERROR => $e->getMessage()]);
        }

        return new RegisterUserResponse(success: true, user: $user);
    }
}