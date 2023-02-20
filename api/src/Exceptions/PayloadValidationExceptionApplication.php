<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PayloadValidationExceptionApplication extends ApplicationBaseException
{
    public function __construct(string $validationErrors, ?Throwable $previous = null)
    {
        parent::__construct(message: $validationErrors, code: Response::HTTP_BAD_REQUEST, previous: $previous);
    }
}