<?php

namespace App\Service;

use App\Dto\CalculationsRequestDto;
use App\Dto\CalculationsResponseDto;
use App\Entity\Calculations;
use App\Exceptions\CalculatorNotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Factory\CalculationsFactory;
use App\Interface\TokenServiceInterface;
use App\Repository\CalculationsRepository;
use App\Repository\CalculatorRepository;
use Symfony\Component\HttpFoundation\Request;

class CalculationsService
{
    public function __construct(
        private readonly TokenServiceInterface    $tokenService,
        private readonly CalculatorService      $calculatorService,
        private readonly CalculationsRepository $calculationsRepository,
        private readonly CalculatorRepository   $calculatorRepository,
        private readonly CalculationsFactory    $calculationsFactory
    )
    {
    }

    /**
     * @return CalculationsResponseDto[]
     * @throws UnauthorizedException
     * @throws CalculatorNotFoundException
     */
    public function getCalculations(Request $request): array
    {
        $token = $this->tokenService->getToken($request);

        if (!$token) {
            throw new UnauthorizedException();
        }

        $calculator = $this->calculatorService->getCalculator($token);

        if (!$calculator) {
            throw new CalculatorNotFoundException();
        }

        $calculations = $this->calculationsRepository->findCalculationsByCalculatorId($calculator->getId());

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
        $calculator = $this->calculatorRepository->findOneBy(['id' => 13]);

        $calculations = $this->calculationsFactory
            ->setCalculator($calculator)
            ->setExpression($dto->getExpression())
            ->setResult($dto->getResult())
            ->setCreatedAt()
            ->create();

        $this->calculationsRepository->save($calculations, true);

        return $dto;
    }
}