<?php

namespace App\Service;

use App\Dto\CalculationsRequestDto;
use App\Dto\CalculationsResponseDto;
use App\Entity\Calculations;
use App\Repository\CalculationsRepository;
use App\Repository\CalculatorRepository;
use Doctrine\ORM\EntityManagerInterface;

class CalculatorService
{

    public function __construct(
        private readonly CalculationsRepository $calculationsRepository,
        private readonly CalculatorRepository $calculatorRepository,
        private readonly EntityManagerInterface $em
    )
    {
    }

    /**
     * @return CalculationsResponseDto[]
     */
    public function getCalculations(int $calculatorId): array
    {
        $calculations = $this->calculationsRepository->findCalculationsByCalculatorId($calculatorId);

        return array_map(
            fn(Calculations $calculation) => new CalculationsResponseDto(
                $calculation->getCalculator()->getId(),
                $calculation->getId(),
                $calculation->getExpression(),
                $calculation->getResult()
            ), $calculations
        );
    }

    public function setCalculations(CalculationsRequestDto $dto): CalculationsRequestDto
    {
        $calculator = $this->calculatorRepository->findOneBy(['id' => 12]);

        $calculations = (new Calculations())
            ->setCalculator($calculator)
            ->setExpression($dto->getExpression())
            ->setResult($dto->getResult())
            ->setCreatedAt(new \DateTimeImmutable());

        $this->em->persist($calculations);
        $this->em->flush();

        return $dto;
    }
}