<?php

namespace Domain\UseCase\Forum\Topic;

use Domain\Entity\Topic;
use Domain\Definition\ErrorStatus;
use Domain\Request\Topic\CreateTopicRequest;
use Domain\Response\Topic\CreateTopicResponse;
use Domain\Port\Repository\UserRepositoryInterface;
use Domain\Port\Repository\TopicRepositoryInterface;

class CreateTopic
{
    public function __construct(
        private TopicRepositoryInterface $topicRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(CreateTopicRequest $request): CreateTopicResponse
    {    
        if ($this->topicRepository->findByTitle($request->getTitle())) {
            return new CreateTopicResponse(success: false, errors: [ErrorStatus::BAD_REQUEST => 'Title already in use']);
        }
        // $user = $this->userRepository->findById($request->getCreatedBy());
        
        $topic = new Topic(
            title: $request->getTitle(),
            description: $request->getDescription(),
            // createdBy: $user->getId()
            );

            try {
                $this->topicRepository->create($topic);
            } catch (\Exception $e) {
                return new CreateTopicResponse(success: false, errors: [ErrorStatus::INTERNAL_ERROR => $e->getMessage()]);
            }
            return new CreateTopicResponse(success: true, topic: $topic);
    }
}