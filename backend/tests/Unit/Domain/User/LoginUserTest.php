<?php

use Domain\Definition\ErrorStatus;
use Domain\UseCase\User\LoginUser;
use Domain\UseCase\User\RegisterUser;
use Domain\Request\User\LoginUserRequest;
use Domain\Validator\Entity\UserValidator;
use Domain\Request\User\RegisterUserRequest;
use Domain\InMemory\Repository\InMemoryUserRepository;
use Domain\InMemory\Repository\InMemoryProfileRepository;


beforeEach(function () {

    $this->userValidator = new UserValidator();
    
    $this->userRepository = new InMemoryUserRepository();
    $this->profileRepository = new InMemoryProfileRepository();

    $this->registerUser = new RegisterUser($this->userValidator, $this->userRepository, $this->profileRepository);
    $this->loginUser = new LoginUser($this->userRepository);

    $this->user = $this->registerUser->execute(new RegisterUserRequest('Tipiak', 'tipiak@reflectiv.com', 'password'));
});


it('should securely login a user', function () {
    $request = new LoginUserRequest('tipiak@reflectiv.com', 'password');
    $response = $this->loginUser->execute($request);
    expect($response->isSuccess())->toBeTrue();

    $token = $response->getToken();
    expect($token)->not()->toBeNull();
});


it('should return error if credentials are invalid', function () {
    $request = new LoginUserRequest('tipiak@reflectiv.com', 'wrongpassword');

    $response = $this->loginUser->execute($request);
    expect($response->isSuccess())->toBeFalse();
    expect($response->getErrors())->toHaveKey(ErrorStatus::BAD_REQUEST);
});