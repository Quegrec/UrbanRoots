<?php

namespace Domain\UseCase\Module;

use Domain\Entity\Module;
use Domain\Definition\ErrorStatus;
use Domain\Response\Module\CreateModuleResponse;
use Domain\Request\User\Module\CreateModuleRequest;
use Domain\Port\Repository\ModuleRepositoryInterface;
use Domain\Port\Repository\UserRepositoryInterface;

class CreateModule
{
    public function __construct(
        private ModuleRepositoryInterface $moduleRepository,
        private UserRepositoryInterface $userRepository
    ) {}
    
    public function execute(CreateModuleRequest $request): CreateModuleResponse
    {
        dump($this->userRepository->findAll());
        $author = $this->userRepository->findById($request->getCreatedBy());
        dump($author->getId());
        if (!$author || $author->getRole() !== 'ROLE_ADMIN') {
            return new CreateModuleResponse(success: false, errors: [ErrorStatus::NOT_FOUND => 'Author not found']);
        }

        $module = new Module(
                title: $request->getTitle(),
                content: $request->getContent(),
                createdBy: $author
        );

        try {b
            $this->moduleRepository->create($module);
        } catch (\Exception $e) {
            return new CreateModuleResponse(success: false, errors: [ErrorStatus::INTERNAL_ERROR => $e->getMessage()]);
        }

        return new CreateModuleResponse(success: true, module: $module);
    }
}