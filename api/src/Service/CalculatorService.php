<?php

namespace App\Service;

use App\Entity\Calculations;
use App\Entity\Calculator;
use App\Model\CalculationListItems;
use App\Model\CalculationListItemsResponse;
use App\Repository\CalculationsRepository;
use App\Repository\CalculatorRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;

class CalculatorService
{

    public function __construct(
        private readonly CalculationsRepository $calculationsRepository,
    )
    {
    }

    public function getCalculations(int $calculatorId): CalculationListItemsResponse
    {

        $calculations = $this->calculationsRepository->findCalculationsByCalculatorId($calculatorId);

        $items = array_map(
            fn(Calculations $calculation) => new CalculationListItems(
                $calculation->getCalculator()->getId(),
                $calculation->getId(),
                $calculation->getExpression(),
                $calculation->getResult()
            ), $calculations
        );

        return new CalculationListItemsResponse($items);
    }
}