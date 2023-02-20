<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CalculatorNotFoundException extends ApplicationBaseException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(message: json_encode(['message' => 'Calculator not found']), code: Response::HTTP_NOT_FOUND, previous: $previous);
    }
}