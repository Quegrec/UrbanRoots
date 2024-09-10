<?php

use Domain\UseCase\User\RegisterUser;
use Domain\UseCase\Module\CreateModule;
use Domain\Validator\Entity\UserValidator;
use Domain\Request\User\RegisterUserRequest;
use Domain\Request\User\Module\CreateModuleRequest;
use Domain\InMemory\Repository\InMemoryUserRepository;
use Domain\InMemory\Repository\InMemoryModuleRepository;
use Domain\InMemory\Repository\InMemoryProfileRepository;

beforeEach(function () {
    $this->userValidator = new UserValidator();
    $this->moduleRepository = new InMemoryModuleRepository();
    $this->userRepository = new InMemoryUserRepository();
    $this->profileRepository = new InMemoryProfileRepository();
    $this->registerUser = new RegisterUser($this->userValidator, $this->userRepository, $this->profileRepository);
    $this->createModule = new CreateModule($this->moduleRepository, $this->userRepository);

    $this->existingUser = $this->registerUser->execute(
        new RegisterUserRequest(
            username: 'admin',
            email: 'admin@racineurbaine.com',
            password: 'password',
            role: ['ROLE_ADMIN']
        )
    )->getUser();
    // dump($this->existingUser);
});

it('should create a module', function () {
    $request = new CreateModuleRequest(
        title: 'Module 1',
        content: 'This is a module',
        createdBy: $this->existingUser->getId()
    );
    dump($request);

    $response = $this->createModule->execute($request);
dump($response);
    expect($response->isSuccess())->toBeTrue();
    expect($response->getModule()->getTitle())
        ->toBeString()
        ->toBe($request->getTitle());
    expect(strlen($response->getModule()->getId()))->toBeGreaterThan(3);
    expect($response->getModule()->getContent())->toBe($request->getContent());
    expect($response->getModule()->getCreatedBy())->toBe($request->getCreatedBy());
});