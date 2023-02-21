<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace App\tests\Unit\Service;

use App\Dto\CalculationsRequestDto;
use App\Dto\CalculationsResponseDto;
use App\Entity\Calculations;
use App\Entity\Calculator;
use App\Entity\Token;
use App\Exceptions\CalculatorNotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Factory\CalculationsFactory;
use App\Interface\TokenServiceInterface;
use App\Repository\CalculationsRepository;
use App\Service\CalculationsService;
use App\Service\CalculatorService;
use App\Service\SessionTokenService;
use App\Tests\Unit\AbstractTestCase;
use Symfony\Component\HttpFoundation\Request;

class CalculationsServiceTest extends AbstractTestCase
{
    private TokenServiceInterface $tokenService;
    private CalculatorService $calculatorService;
    private CalculationsRepository $calculationsRepository;
    private CalculationsFactory $calculationsFactory;
    private CalculationsService $calculationsService;
    private Token $token;
    private Calculator $calculator;
    private Calculations $calculations;
    private Request $request;

    protected function setUp(): void
    {
        $this->tokenService = $this->createMock(SessionTokenService::class);
        $this->calculatorService = $this->createMock(CalculatorService::class);
        $this->calculationsRepository = $this->createMock(CalculationsRepository::class);
        $this->calculationsFactory = $this->createMock(CalculationsFactory::class);

        $this->request = $this->createStub(Request::class);

        $this->calculationsService = new CalculationsService(
            $this->tokenService,
            $this->calculatorService,
            $this->calculationsRepository,
            $this->calculationsFactory
        );

        $this->token = (new Token())
            ->setValue('abcdef');
        $this->setEntityId($this->token, 15);

        $this->calculator = (new Calculator())
            ->setToken($this->token)
            ->setCreatedAt(new \DateTimeImmutable('2023-03-03'));
        $this->setEntityId($this->calculator, 15);

        $this->calculations = (new Calculations())
            ->setCalculator($this->calculator)
            ->setExpression('2 + 2')
            ->setResult('4.0')
            ->setCreatedAt(new \DateTimeImmutable('2023-03-03'));
        $this->setEntityId($this->calculations, 15);
    }

    public function testGetCalculations()
    {
        $this->tokenService
            ->expects($this->once())
            ->method('getToken')
            ->with($this->request)
            ->willReturn($this->token);

        $this->calculatorService
            ->expects($this->once())
            ->method('getCalculator')
            ->with($this->token)
            ->willReturn($this->calculator);

        $this->calculationsRepository
            ->expects($this->once())
            ->method('getLastNCalculations')
            ->with($this->calculator->getId(), 5)
            ->willReturn([$this->calculations]);

        $expected = new CalculationsResponseDto(
            $this->calculator->getId(),
            $this->calculations->getId(),
            $this->calculations->getExpression(),
            $this->calculations->getResult()
        );

        $this->assertEquals(
            [$expected],
            $this->calculationsService->getCalculations($this->request)
        );
    }

    public function testGetCalculationsThrowsUnauthorizedException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');

        $this->tokenService
            ->expects($this->once())
            ->method('getToken')
            ->with($this->request)
            ->willReturn(null);

        $this->calculationsService->getCalculations($this->request);
    }

    public function testGetCalculationsThrowsCalculatorNotFoundException()
    {
        $this->expectException(CalculatorNotFoundException::class);
        $this->expectExceptionMessage('Calculator not found');

        $this->tokenService
            ->expects($this->once())
            ->method('getToken')
            ->with($this->request)
            ->willReturn($this->token);

        $this->calculatorService
            ->expects($this->once())
            ->method('getCalculator')
            ->with($this->token)
            ->willReturn(null);

        $this->calculationsService->getCalculations($this->request);
    }

    public function testSetCalculations()
    {
        $dto = (new CalculationsRequestDto())
            ->setExpression('2 + 2')
            ->setResult('4.0');

        $this->tokenService
            ->expects($this->once())
            ->method('getToken')
            ->with($this->request)
            ->willReturn($this->token);

        $this->calculatorService
            ->expects($this->once())
            ->method('getCalculator')
            ->with($this->token)
            ->willReturn($this->calculator);

        $this->calculationsFactory
            ->expects($this->once())
            ->method('setCalculator')
            ->with($this->calculator)
            ->willReturnSelf();

        $this->calculationsFactory
            ->expects($this->once())
            ->method('setExpression')
            ->with($dto->getExpression())
            ->willReturnSelf();

        $this->calculationsFactory
            ->expects($this->once())
            ->method('setResult')
            ->with($dto->getResult())
            ->willReturnSelf();

        $this->calculationsFactory
            ->expects($this->once())
            ->method('setCreatedAt')
            ->willReturnSelf();

        $this->calculationsFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->calculations);

        $this->calculationsRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->calculations, true);

        $this->assertEquals(
            $dto,
            $this->calculationsService->setCalculations($dto, $this->request)
        );
    }
}
