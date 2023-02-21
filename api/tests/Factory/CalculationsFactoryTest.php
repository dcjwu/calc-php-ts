<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Calculator;
use App\Entity\Token;
use App\Factory\CalculationsFactory;
use PHPUnit\Framework\TestCase;

class CalculationsFactoryTest extends TestCase
{
    public function testCreateCalculations()
    {
        $token = (new Token())
            ->setValue('abcde');

        $calculator = (new Calculator())
            ->setToken($token)
            ->setCreatedAt(\DateTimeImmutable::createFromFormat(DATE_W3C, '2023-04-04T00:00:00+00:00'));

        $calculations = (new CalculationsFactory())
            ->setCalculator($calculator)
            ->setExpression('2 + 2')
            ->setResult(4.0)
            ->setCreatedAt()
            ->create();

        $this->assertSame($calculator, $calculations->getCalculator());
        $this->assertSame('2 + 2', $calculations->getExpression());
        $this->assertSame(4.0, $calculations->getResult());
    }
}
