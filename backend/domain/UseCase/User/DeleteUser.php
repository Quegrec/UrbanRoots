<?php

namespace Domain\UseCase\User;

use Domain\Entity\User;
use Domain\UseCase\UseCase;
use Domain\Definition\ErrorStatus;
use Domain\Request\User\DeleteUserRequest;
use Domain\Response\User\DeleteUserResponse;
use Domain\Port\Repository\UserRepositoryInterface;

class DeleteUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function execute(DeleteUserRequest $request): DeleteUserResponse
    {
        $user = $this->userRepository->findById($request->getId());

        if (!$user) {
            return new DeleteUserResponse(success: false, errors: [ErrorStatus::NOT_FOUND => 'User not found']);
        }

        try {
            $this->userRepository->delete($user->getId());
        } catch (\Exception $e) {
            return new DeleteUserResponse(success: false, errors: [ErrorStatus::INTERNAL_ERROR => $e->getMessage()]);
        }

        return new DeleteUserResponse(success: true);
    }
}