<?php

namespace App\Service;

use App\Entity\Calculator;
use App\Entity\Token;
use App\Factory\CalculatorFactory;
use App\Repository\CalculatorRepository;
use Symfony\Component\Process\Exception\LogicException;

class CalculatorService
{
    public function __construct(
        private readonly CalculatorRepository $calculatorRepository,
        private readonly CalculatorFactory $calculatorFactory
    )
    {
    }

    public function getCalculator(Token $token): Calculator|null
    {
        return $this->calculatorRepository->findOneBy(['token' => $token]);
    }

    public function createCalculator(Token $token): Calculator
    {
        $calculator = $this->getCalculator($token);

        if ($calculator) {
            throw new LogicException('Calculator already exists');
        }

        $newCalculator = $this->calculatorFactory
            ->setToken($token)
            ->setCreatedAt()
            ->create();

        $this->calculatorRepository->save($newCalculator, true);

        return $newCalculator;
    }
}