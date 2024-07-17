<?php


use Domain\Entity\Profile;
use Domain\UseCase\User\RegisterUser;
use Domain\Validator\Entity\UserValidator;
use Domain\Request\User\RegisterUserRequest;
use Domain\InMemory\Repository\InMemoryUserRepository;
use Domain\InMemory\Repository\InMemoryProfileRepository;


beforeEach(function () {
    $this->userValidator = new UserValidator();
    $this->userRepository = new InMemoryUserRepository();
    $this->profileRepository = new InMemoryProfileRepository();
    $this->registerUser = new RegisterUser($this->userValidator, $this->userRepository, $this->profileRepository);

    $this->existingUser = $this->registerUser->execute(
        new RegisterUserRequest(
            username: 'admin',
            email: 'admin@racineurbaine.com',
            password: 'password',
            role: ['ROLE_ADMIN']
        )
    )->getUser();
});


it('should register a user', function () {
    $request = new RegisterUserRequest(
        username: 'Quegrec',
        email: 'thoms.querrec@gmail.com',
        password: 'ThisIsMyPassword'
    );

    $response = $this->registerUser->execute($request);

    expect($response->isSuccess())->toBeTrue();
    expect($response->getUser()->getUsername())
        ->toBeString()
        ->toBe($request->getUsername());
    expect(strlen($response->getUser()->getId()))->toBeGreaterThan(3);
    expect($response->getUser()->getEmail())->toBe($request->getEmail());
    expect($response->getUser()->getPassword())->not->toBe($request->getPassword());
    expect(strlen($response->getUser()->getPassword()))->toBeGreaterThanOrEqual(60);
    expect($response->getUser()->getRole())->toBe($request->getRole());

    $userId = $response->getUser()->getId();
    $profile = $this->profileRepository->findByUserId($userId);
    expect($profile)
        ->not->toBeNull()
        ->toBeInstanceOf(Profile::class);
    expect($profile->getUser()->getId())->toBe($userId);
});


it('should not register a user with invalid request', function () {
    $request = new RegisterUserRequest(
        username: 'ad',
        email: 'a@a',
        password: 'pass'
    );

    $response = $this->registerUser->execute($request);

    expect($response->isSuccess())->toBeFalse();
    expect($response->getErrors())
        ->toBeArray()
        ->toHaveCount(1)
        ->toHaveKey('invalid_param');
    expect($response->getErrors()['invalid_param'])
        ->toBeArray()
        ->toHaveCount(3)
        ->toHaveKeys(['username', 'email', 'password']);
});


it('should not register a user with an existing email', function () {
    $request = new RegisterUserRequest(
        username: 'Quegrec',
        email: 'admin@racineurbaine.com',
        password: 'password',
        role: ['ROLE_ADMIN']
    );

    $response = $this->registerUser->execute($request);

    expect($response->isSuccess())->toBeFalse();
    expect($response->getErrors())
        ->toBeArray()
        ->toHaveCount(1)
        ->toHaveKey('bad_request')
        ->toHaveAttribute('Email already in use');
});


it('should not register a user with an existing username', function () {
    $request = new RegisterUserRequest(
        username: 'admin',
        email: 'new@outlook.com',
        password: 'password'
    );

    $response = $this->registerUser->execute($request);

    expect($response->isSuccess())->toBeFalse();
    expect($response->getErrors())
        ->toBeArray()
        ->toHaveCount(1)
        ->toHaveKey('bad_request')
        ->toHaveAttribute('Username taken');
});