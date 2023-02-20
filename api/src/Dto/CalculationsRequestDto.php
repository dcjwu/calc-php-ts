<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CalculationsRequestDto
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    protected $expression;

    #[Assert\NotBlank]
    #[Assert\Type('float')]
    protected $result;

    public function getExpression()
    {
        return $this->expression;
    }

    public function setExpression($expression): void
    {
        $this->expression = $expression;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result): void
    {
        $this->result = $result;
    }
}