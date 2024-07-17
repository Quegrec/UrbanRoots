<?php


use Domain\UseCase\User\RateUser;
use Domain\UseCase\User\RegisterUser;
use Domain\Request\User\RateUserRequest;
use Domain\Validator\Entity\UserValidator;
use Domain\Request\User\RegisterUserRequest;
use Domain\InMemory\Repository\InMemoryUserRepository;
use Domain\InMemory\Repository\InMemoryProfileRepository;


beforeEach(function () {
    $this->userValidator = new UserValidator();
    $this->userRepository = new InMemoryUserRepository();
    $this->profileRepository = new InMemoryProfileRepository();
    
    $this->registerUser = new RegisterUser($this->userValidator, $this->userRepository, $this->profileRepository);
    $this->rateUser = new RateUser($this->userRepository);
    
    $this->rater = $this->registerUser->execute(
        new RegisterUserRequest(
            username: 'rater',
            email: 'rater@mail.com',
            password: 'password',
        )
    )->getUser();
    $this->ratee = $this->registerUser->execute(
        new RegisterUserRequest(
            username: 'ratee',
            email: 'ratee@mail.com',
            password: 'password',
        )
    )->getUser();
});


it('should rate a user', function () {
    $response = $this->rateUser->execute(
        new RateUserRequest(
            raterId: $this->rater->getId(),
            rateeId: $this->ratee->getId(),
            comment: 'Great user'
        )
    );

    expect($response->isSuccess())->toBeTrue();
    expect($response->getUserRating()->getRatee())->toBe($this->ratee);
    expect($response->getUserRating()->getRater())->toBe($this->rater);
    expect($this->ratee->getRatings())->toHaveCount(1);
    expect($this->ratee->getRatings()[0]->getComment())->toBe('Great user');

    $ratee = $this->userRepository->findById($this->ratee->getId());
    expect($ratee->getRatings())->toHaveCount(1);
});


it('should not rate a user if rater not found', function () {
    $response = $this->rateUser->execute(
        new RateUserRequest(
            raterId: 'invalid-id',
            rateeId: $this->ratee->getId(),
            comment: 'Great user'
        )
    );

    expect($response->isSuccess())->toBeFalse();
    expect($response->getErrors())->toHaveKey('not_found');
    expect($response->getErrors()['not_found'])->toBe('User not found');
});


it('should not rate a user if ratee not found', function () {
    $response = $this->rateUser->execute(
        new RateUserRequest(
            raterId: $this->rater->getId(),
            rateeId: 'invalid-id',
            comment: 'Great user'
        )
    );

    expect($response->isSuccess())->toBeFalse();
    expect($response->getErrors())->toHaveKey('not_found');
    expect($response->getErrors()['not_found'])->toBe('User not found');
});


it('should not rate a user if rater is the same as ratee', function () {
    $response = $this->rateUser->execute(
        new RateUserRequest(
            raterId: $this->rater->getId(),
            rateeId: $this->rater->getId(),
            comment: 'Great user'
        )
    );

    expect($response->isSuccess())->toBeFalse();
    expect($response->getErrors())->toHaveKey('bad_request');
    expect($response->getErrors()['bad_request'])->toBe('You cannot rate yourself');
});