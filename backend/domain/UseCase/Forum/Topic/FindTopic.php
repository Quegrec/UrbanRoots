<?php

namespace Domain\UseCase\Forum\Topic;

use Domain\Request\Topic\FindTopicRequest;
use Domain\Response\Topic\FindTopicResponse;
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
            $topics = $this->topicRepository->findByTitle($request->getTitle());
        } else {
            $topics = $this->topicRepository->findAll();
        }
        
        return new FindTopicResponse(
            success: true,
            errors: [],
            topics: $topics,
        );
    }
}