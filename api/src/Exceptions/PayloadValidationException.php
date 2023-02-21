<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class PayloadValidationException extends ApplicationBaseException
{
    public function __construct(string $validationErrors, ?\Throwable $previous = null)
    {
        parent::__construct(message: $validationErrors, code: Response::HTTP_BAD_REQUEST, previous: $previous);
    }
}
