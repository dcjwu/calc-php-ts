<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Calculator;
use App\Entity\Token;

class CalculatorFactory
{
    private Calculator $calculator;

    public function __construct()
    {
        $this->calculator = new Calculator();
    }

    public function setToken(Token $token): CalculatorFactory
    {
        $this->calculator->setToken($token);

        return $this;
    }

    public function setCreatedAt(): CalculatorFactory
    {
        $this->calculator->setCreatedAt(new \DateTimeImmutable());

        return $this;
    }

    public function create(): Calculator
    {
        return $this->calculator;
    }
}
