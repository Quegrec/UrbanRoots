<?php

namespace App\Helper;

use Domain\Definition\ErrorStatus;
use Domain\Response\DomainResponseInterface;

class ResponseHandler
{
    /**
     * Handle the domain response by returning the appropriate status code.
     *
     * @param DomainResponseInterface $response
     * @return Response $response
     * @throws \Exception
     */
    public static function handle(DomainResponseInterface $response): Response
    {
        if ($response->isSuccess()) {
            return new Response(200);
        }

        if (isset($response->getErrors()[ErrorStatus::INTERNAL_ERROR])) {
            return new Response(500, $response->getErrors());
        }

        if (isset($response->getErrors()[ErrorStatus::BAD_REQUEST])) {
            return new Response(400, $response->getErrors());
        }

        if (isset($response->getErrors()[ErrorStatus::UNAUTHORIZED])) {
            return new Response(401, $response->getErrors());
        }

        if (isset($response->getErrors()[ErrorStatus::FORBIDDEN])) {
            return new Response(403, $response->getErrors());
        }

        if (isset($response->getErrors()[ErrorStatus::NOT_FOUND])) {
            return new Response(404, $response->getErrors());
        }

        if (isset($response->getErrors()[ErrorStatus::INVALID_PARAM])) {
            return new Response(422, $response->getErrors()[ErrorStatus::INVALID_PARAM]);
        }

        return new Response(422, $response->getErrors());
    }
}

class Response
{
    public function __construct(
        private int $statusCode,
        private ?array $errors = []
    ) {}

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}