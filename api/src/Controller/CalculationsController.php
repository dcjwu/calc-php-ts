<?php

namespace App\Controller;

use App\Dto\CalculationsRequestDto;
use App\Exceptions\CalculatorNotFoundException;
use App\Exceptions\PayloadValidationException;
use App\Exceptions\UnauthorizedException;
use App\Service\CalculationsService;
use App\Validator\RequestBodyValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CalculationsController extends AbstractController
{
    public function __construct(
        private readonly CalculationsService $calculationsService,
        private readonly RequestBodyValidator $requestBodyValidator
    ) {
    }

    /**
     * @throws UnauthorizedException
     * @throws CalculatorNotFoundException
     */
    #[Route('/calculations', name: 'get_calculations', methods: 'GET')]
    public function getCalculations(Request $request): JsonResponse
    {
        return $this->json($this->calculationsService->getCalculations($request));
    }

    /**
     * @throws PayloadValidationException
     */
    #[Route('/calculations', name: 'set_calculations', methods: 'POST')]
    public function setCalculations(Request $request): JsonResponse
    {
        $dto = $this->requestBodyValidator->validate($request, CalculationsRequestDto::class);

        return $this->json($this->calculationsService->setCalculations($dto, $request));
    }
}
