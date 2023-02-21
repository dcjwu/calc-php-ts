<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CalculationsRequestDto
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    protected $expression;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    protected $result;

    public function getExpression()
    {
        return $this->expression;
    }

    public function setExpression($expression): self
    {
        $this->expression = $expression;

        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result): self
    {
        $this->result = $result;

        return $this;
    }
}
