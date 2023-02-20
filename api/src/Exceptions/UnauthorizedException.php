<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UnauthorizedException extends ApplicationBaseException
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct(message: json_encode(['message' => 'Unauthorized']), code: Response::HTTP_UNAUTHORIZED, previous: $previous);
    }
}
