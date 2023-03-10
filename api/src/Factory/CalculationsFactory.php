<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Calculations;
use App\Entity\Calculator;

class CalculationsFactory
{
    private Calculations $calculations;

    public function __construct()
    {
        $this->calculations = new Calculations();
    }

    public function setCalculator(Calculator $calculator): CalculationsFactory
    {
        $this->calculations->setCalculator($calculator);

        return $this;
    }

    public function setExpression(string $expression): CalculationsFactory
    {
        $this->calculations->setExpression($expression);

        return $this;
    }

    public function setResult(string $result): CalculationsFactory
    {
        $this->calculations->setResult($result);

        return $this;
    }

    public function setCreatedAt(): CalculationsFactory
    {
        $this->calculations->setCreatedAt(new \DateTimeImmutable());

        return $this;
    }

    public function create(): Calculations
    {
        return $this->calculations;
    }
}
