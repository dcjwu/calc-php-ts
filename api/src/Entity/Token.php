<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TokenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
class Token
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\OneToMany(mappedBy: 'token', targetEntity: Calculator::class, orphanRemoval: true)]
    private Collection $calculator;

    public function __construct()
    {
        $this->calculator = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, Calculator>
     */
    public function getCalculator(): Collection
    {
        return $this->calculator;
    }

    public function addCalculator(Calculator $calculator): self
    {
        if (!$this->calculator->contains($calculator)) {
            $this->calculator->add($calculator);
            $calculator->setToken($this);
        }

        return $this;
    }

    public function removeCalculator(Calculator $calculator): self
    {
        if ($this->calculator->removeElement($calculator)) {
            // set the owning side to null (unless already changed)
            if ($calculator->getToken() === $this) {
                $calculator->setToken(null);
            }
        }

        return $this;
    }
}
