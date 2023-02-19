<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Calculator::class)]
    private Collection $calculator;

    #[ORM\Column(length: 255)]
    private ?string $identifier = null;

    public function __construct()
    {
        $this->calculator = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $calculator->setSession($this);
        }

        return $this;
    }

    public function removeCalculator(Calculator $calculator): self
    {
        if ($this->calculator->removeElement($calculator)) {
            // set the owning side to null (unless already changed)
            if ($calculator->getSession() === $this) {
                $calculator->setSession(null);
            }
        }

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }
}
