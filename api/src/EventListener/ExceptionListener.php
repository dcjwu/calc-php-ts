<?php

namespace App\EventListener;

use App\Exceptions\ApplicationBaseException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class ExceptionListener
{
    public function __construct(
        private readonly KernelInterface $kernel
    )
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse();

        if ($exception instanceof ApplicationBaseException || $this->kernel->getEnvironment() === 'dev') {
            $code = $exception->getCode();

            if ($code === 0) {
                $content = [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace()
                ];
                $response->setContent(json_encode($content));

            } else {
                $response->setStatusCode($exception->getCode());
                $response->setContent($exception->getMessage());
            }

        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent('Internal server error');
        }

        $event->setResponse($response);
    }
}