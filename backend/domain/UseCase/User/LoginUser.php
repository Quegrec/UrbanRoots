<?php

namespace Domain\UseCase\User;

use Domain\Entity\User;
use Domain\Tool\AuthManager;
use Domain\Definition\ErrorStatus;
use Domain\Request\User\LoginUserRequest;
use Domain\Response\User\LoginUserResponse;
use Domain\Port\Repository\UserRepositoryInterface;


class LoginUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function execute(LoginUserRequest $request): LoginUserResponse
    {
        $user = $this->userRepository->findByEmail($request->getEmail());

        if (!$user || !$user instanceof User) {
            return new LoginUserResponse(success: false, errors: [ErrorStatus::NOT_FOUND => 'User not found']);
        }

        if (!AuthManager::verifyPassword($request->getPassword(), $user->getPassword())) {
            return new LoginUserResponse(success: false, errors: [ErrorStatus::BAD_REQUEST => 'Invalid password']);
        }

        $user->login();

        try {
            $this->userRepository->update($user);
        } catch (\Exception $e) {
            return new LoginUserResponse(success: false, errors: [ErrorStatus::INTERNAL_ERROR => 'An error occurred while updating the user']);
        }

        return new LoginUserResponse(success: true, token: AuthManager::generateToken());
    }
}