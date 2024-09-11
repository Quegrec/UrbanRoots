<?php

namespace Domain\UseCase\Forum\Topic;

use Domain\Request\Forum\Topic\FindTopicRequest;
use Domain\Response\Forum\Topic\FindTopicResponse;
use Domain\Port\Repository\TopicRepositoryInterface;

class FindTopic
{
    public function __construct(
        private TopicRepositoryInterface $topicRepository
    ) {
    }

    public function execute(FindTopicRequest $request): FindTopicResponse
    {
        if (!is_null($request->getTitle())) {
            $topic = $this->topicRepository->findByTitle($request->getTitle());
        } else {
            $topic = $this->topicRepository->findAll();
        }
        
        return new FindTopicResponse(
            success: true,
            errors: [],
            topic: $topic,
        );
    }
}