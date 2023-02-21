<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace App\Tests\Service;

use App\Entity\Calculator;
use App\Entity\Token;
use App\Factory\CalculatorFactory;
use App\Repository\CalculatorRepository;
use App\Service\CalculatorService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Exception\LogicException;

class CalculatorServiceTest extends TestCase
{
    private CalculatorRepository $calculatorRepository;
    private CalculatorFactory $calculatorFactory;
    private CalculatorService $calculatorService;

    private Token $token;
    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculatorRepository = $this->createMock(CalculatorRepository::class);
        $this->calculatorFactory = $this->createMock(CalculatorFactory::class);

        $this->calculatorService = new CalculatorService(
            $this->calculatorRepository,
            $this->calculatorFactory
        );

        $this->token = (new Token())
            ->setValue('abcdef');

        $this->calculator = (new Calculator())
            ->setToken($this->token)
            ->setCreatedAt(new \DateTimeImmutable('2023-01-01'));
    }

    public function testGetCalculator()
    {
        $this->calculatorRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['token' => $this->token])
            ->willReturn($this->calculator);

        $this->assertEquals(
            $this->calculator,
            $this->calculatorService->getCalculator($this->token)
        );
    }

    public function testGetCalculatorReturnsNull()
    {
        $this->calculatorRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['token' => $this->token])
            ->willReturn(null);

        $this->assertEquals(
            null,
            $this->calculatorService->getCalculator($this->token)
        );
    }

    public function testCreateCalculator()
    {
        $this->calculatorRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['token' => $this->token])
            ->willReturn(null);

        $this->calculatorFactory
            ->expects($this->once())
            ->method('setToken')
            ->with($this->token)
            ->willReturnSelf();

        $this->calculatorFactory
            ->expects($this->once())
            ->method('setCreatedAt')
            ->willReturnSelf();

        $this->calculatorFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->calculator);

        $this->calculatorRepository
            ->expects($this->once())
            ->method('save');

        $this->calculatorService->createCalculator($this->token);
    }

    public function testCreateCalculatorThrowsException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Calculator already exists');

        $this->calculatorRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['token' => $this->token])
            ->willReturn($this->calculator);

        $this->calculatorService->createCalculator($this->token);
    }
}
