<?php

namespace App\Controller;

use App\Service\CalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CalculatorController extends AbstractController
{
    public function __construct(
        private readonly CalculatorService $calculatorService,
    )
    {
    }

    #[Route('/calculator', name: 'get_calculations', methods: 'GET')]
    public function getCalculations(): JsonResponse
    {

        return $this->json($this->calculatorService->getCalculations(1));
    }

    #[Route('/calculator', name: 'set_calculations', methods: 'POST')]
    public function setCalculations(): JsonResponse
    {
        return $this->json(['calcId' => 'alo']);
    }
}
