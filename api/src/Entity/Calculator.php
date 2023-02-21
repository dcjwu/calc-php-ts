<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CalculatorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalculatorRepository::class)]
class Calculator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'calculator', targetEntity: Calculations::class, orphanRemoval: true)]
    private Collection $calculations;

    #[ORM\ManyToOne(inversedBy: 'calculator')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Token $token = null;

    public function __construct()
    {
        $this->calculations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Calculations>
     */
    public function getCalculations(): Collection
    {
        return $this->calculations;
    }

    public function addCalculation(Calculations $calculation): self
    {
        if (!$this->calculations->contains($calculation)) {
            $this->calculations->add($calculation);
            $calculation->setCalculator($this);
        }

        return $this;
    }

    public function removeCalculation(Calculations $calculation): self
    {
        if ($this->calculations->removeElement($calculation)) {
            // set the owning side to null (unless already changed)
            if ($calculation->getCalculator() === $this) {
                $calculation->setCalculator(null);
            }
        }

        return $this;
    }

    public function getToken(): ?Token
    {
        return $this->token;
    }

    public function setToken(?Token $token): self
    {
        $this->token = $token;

        return $this;
    }
}
