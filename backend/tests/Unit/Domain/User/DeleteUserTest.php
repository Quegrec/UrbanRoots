<?php


use Domain\UseCase\User\DeleteUser;
use Domain\UseCase\User\RegisterUser;
use Domain\Request\User\DeleteUserRequest;
use Domain\Validator\Entity\UserValidator;
use Domain\Request\User\RegisterUserRequest;
use Domain\InMemory\Repository\InMemoryUserRepository;
use Domain\InMemory\Repository\InMemoryProfileRepository;


beforeEach(function () {
    $this->userValidator = new UserValidator();
    $this->userRepository = new InMemoryUserRepository();
    $this->profileRepository = new InMemoryProfileRepository();
    $this->registerUser = new RegisterUser($this->userValidator, $this->userRepository, $this->profileRepository);
    $this->DeleteUser = new DeleteUser($this->userRepository);

    $this->existingUser = $this->registerUser->execute(
        new RegisterUserRequest(
            username: 'userToDelete',
            email: 'user@mail.com',
            password: 'password',
        )
    )->getUser();
});


it('should delete a user ', function () {
    $response = $this->DeleteUser->execute(new DeleteUserRequest($this->existingUser->getId()));

    expect($response->isSuccess())->toBeTrue();
    expect($this->userRepository->findById($this->existingUser->getId()))->toBeNull();
});


it('should return an error if user not found', function () {
    $response = $this->DeleteUser->execute(new DeleteUserRequest('nonExistingId'));

    expect($response->isSuccess())->toBeFalse();
    expect($response->getErrors())
        ->toBeArray()
        ->toHaveCount(1)
        ->toHaveKey('not_found')
        ->toHaveAttribute('User not found');
});