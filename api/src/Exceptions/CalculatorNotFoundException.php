<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class CalculatorNotFoundException extends ApplicationBaseException
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct(message: json_encode(['message' => 'Calculator not found']), code: Response::HTTP_NOT_FOUND, previous: $previous);
    }
}
