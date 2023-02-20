<?php

namespace App\Service;

use App\Entity\Calculator;
use App\Entity\Token;
use App\Repository\CalculatorRepository;

class CalculatorService
{
    public function __construct(
        private readonly CalculatorRepository $calculatorRepository
    )
    {
    }

    public function getCalculator(Token $token): Calculator|null
    {
        return $this->calculatorRepository->findOneBy(['token' => $token]);
    }
}