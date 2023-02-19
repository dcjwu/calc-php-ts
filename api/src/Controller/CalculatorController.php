<?php

namespace App\Controller;

use App\Handler\CalculatorHandler;
use App\Service\CalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CalculatorController extends AbstractController
{
    public function __construct(
        private readonly CalculatorHandler $calculatorHandler,
        private readonly CalculatorService $calculatorService,
    )
    {
    }

    #[Route('/calculator', name: 'get_calculations', methods: 'GET')]
    public function getCalculations(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $calculator = $this->calculatorHandler->get($session);

        return $this->json($this->calculatorService->getCalculations($calculator->getId()));
    }

    #[Route('/calculator', name: 'set_calculations', methods: 'POST')]
    public function setCalculations(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $calculator = $this->calculatorHandler->get($session);

        return $this->json(['calcId' => $calculator->getId()]);
    }
}
