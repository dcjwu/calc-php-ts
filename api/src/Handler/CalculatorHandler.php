<?php

namespace App\Handler;

use App\Entity\Calculator;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class CalculatorHandler
{
    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly EntityManagerInterface $em
    )
    {
    }

    public function get(Session $session): Calculator
    {
        $sessionId = $session->getId();

        if (!$sessionId) {
            return $this->create();
        }

        $session = $this->sessionRepository->findOneBy(['identifier' => $sessionId]);
        return $session->getCalculator()->first();
    }

    public function create(): Calculator
    {
        $session = new Session();
        $session->start();

        $sessionEntity = (new \App\Entity\Session())
            ->setIdentifier($session->getId());

        $this->em->persist($sessionEntity);

        $calculator = (new Calculator())
            ->setSession($sessionEntity)
            ->setCreatedAt(new \DateTimeImmutable());

        $this->em->persist($calculator);

        $this->em->flush();

        return $calculator;
    }
}