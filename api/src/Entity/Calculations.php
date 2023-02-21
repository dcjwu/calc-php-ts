<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CalculationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalculationsRepository::class)]
class Calculations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $expression = null;

    #[ORM\Column]
    private ?float $result = null;

    #[ORM\ManyToOne(inversedBy: 'calculations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Calculator $calculator = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpression(): ?string
    {
        return $this->expression;
    }

    public function setExpression(string $expression): self
    {
        $this->expression = $expression;

        return $this;
    }

    public function getResult(): ?float
    {
        return $this->result;
    }

    public function setResult(float $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getCalculator(): ?Calculator
    {
        return $this->calculator;
    }

    public function setCalculator(?Calculator $calculator): self
    {
        $this->calculator = $calculator;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
