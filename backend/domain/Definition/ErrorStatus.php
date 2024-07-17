<?php

namespace Domain\Definition;

/**
 * All global response status should be defined here
 */
class ErrorStatus
{
    public const NOT_FOUND = 'not_found';
    public const INVALID_PARAM = 'invalid_param';
    public const BAD_REQUEST = 'bad_request';
    public const UNAUTHORIZED = 'unauthorized';
    public const FORBIDDEN = 'forbidden';
    public const INTERNAL_ERROR = 'internal_error';
}
