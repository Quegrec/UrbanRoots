<?php

namespace Domain\UseCase\User;

use Domain\Entity\UserRating;
use Domain\Definition\ErrorStatus;
use Domain\Request\User\RateUserRequest;
use Domain\Response\User\RateUserResponse;
use Domain\Port\Repository\UserRepositoryInterface;

class RateUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function execute(RateUserRequest $request): RateUserResponse
    {
        $rater = $this->userRepository->findById($request->getRaterId());
        $ratee = $this->userRepository->findById($request->getRateeId());

        if (!$rater || !$ratee) {
            return new RateUserResponse(success: false, errors: [ErrorStatus::NOT_FOUND => 'User not found']);
        }

        if ($rater->getId() === $ratee->getId()) {
            return new RateUserResponse(success: false, errors: [ErrorStatus::BAD_REQUEST => 'You cannot rate yourself']);
        }

        // TODO:
        // if ($rater->hasRated($ratee)) {
        //     return new RateUserResponse(success: false, errors: [ErrorStatus::BAD_REQUEST => 'You have already rated this user']);
        // }

        $rating = new UserRating(
            rater: $rater,
            ratee: $ratee,
            comment: $request->getComment(),
            createdAt: new \DateTime()
        );

        $ratee->addRating($rating);

        try {
            $this->userRepository->update($ratee);
        } catch (\Exception $e) {
            return new RateUserResponse(success: false, errors: [ErrorStatus::INTERNAL_ERROR => $e->getMessage()]);
        }

        return new RateUserResponse(success: true, UserRating: $rating);
    }
}