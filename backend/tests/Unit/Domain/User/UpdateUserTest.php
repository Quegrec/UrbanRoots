<?php


use Domain\UseCase\User\UpdateUser;
use Domain\UseCase\User\RegisterUser;
use Domain\Request\User\UpdateUserRequest;
use Domain\Validator\Entity\UserValidator;
use Domain\Request\User\RegisterUserRequest;
use Domain\InMemory\Repository\InMemoryUserRepository;
use Domain\InMemory\Repository\InMemoryProfileRepository;


beforeEach(function () {
    $this->userValidator = new UserValidator();
    $this->userRepository = new InMemoryUserRepository();
    $this->profileRepository = new InMemoryProfileRepository();
    $this->registerUser = new RegisterUser($this->userValidator, $this->userRepository, $this->profileRepository);
    $this->updateUser = new UpdateUser($this->userValidator, $this->userRepository);

    $this->existingUser = $this->registerUser->execute(
        new RegisterUserRequest(
            username: 'admin',
            email: 'admin@racineurbaine.fr',
            password: 'password',
            role: ['ROLE_ADMIN']
        )
    )->getUser();

    $this->userToUpdate = $this->registerUser->execute(
        new RegisterUserRequest(
            username: 'userToUpdate',
            email: 'temporary@mail.com',
            password: 'password',
        )
    )->getUser();
});


it('should update a user ', function () {
    $request = new UpdateUserRequest(
        id: $this->userToUpdate->getId(),
        username: 'newUsername',
        email: 'new@mail.com',
        password: 'newPassword',
    );

    $response = $this->updateUser->execute($request, $this->userToUpdate->getId());

    expect($response->isSuccess())->toBeTrue();
    expect($response->getUser()->getUsername())
        ->toBeString()
        ->toBe($request->getUsername());
    expect(strlen($response->getUser()->getId()))->toBeGreaterThan(3);
    expect($response->getUser()->getEmail())->toBe($request->getEmail());
    expect($response->getUser()->getPassword())->not->toBe($request->getPassword());
    expect(strlen($response->getUser()->getPassword()))->toBeGreaterThanOrEqual(60);
});


it('should not update a user with invalid request', function () {
    $request = new UpdateUserRequest(
        id: $this->userToUpdate->getId(),
        username: 'ad',
        email: 'a@a',
        password: '123',
    );

    $response = $this->updateUser->execute($request, $this->userToUpdate->getId());

    expect($response->isSuccess())->toBeFalse();
    expect($response->getErrors())
        ->toBeArray();
});
    