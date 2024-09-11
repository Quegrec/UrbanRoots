<?php

namespace Domain\UseCase\Forum\Post;

use Domain\Request\Forum\Post\FindPostRequest;
use Domain\Response\Forum\Post\FindPostResponse;
use Domain\Port\Repository\PostRepositoryInterface;

class FindPost
{
    public function __construct(
        private PostRepositoryInterface $postRepository
    ) {
    }

    public function execute(FindPostRequest $request): FindPostResponse
    {
        if (!is_null($request->getTopicId())){
            $posts = $this->postRepository->findByTopicId($request->getTopicId());
        }

        return new FindPostResponse(
            success: true,
            errors: [],
            posts: $posts,
            // post: $post
        );
    }
}