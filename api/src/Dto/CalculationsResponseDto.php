<?php

namespace App\Dto;

class CalculationsResponseDto
{
    public function __construct(
        private readonly int $calculatorId,
        private readonly int $id,
        private readonly string $expression,
        private readonly float $result
    ) {
    }

    public function getCalculatorId(): int
    {
        return $this->calculatorId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function getResult(): float
    {
        return $this->result;
    }
}
