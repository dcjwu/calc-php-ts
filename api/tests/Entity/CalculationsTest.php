<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Calculations;
use App\Entity\Calculator;
use App\Entity\Token;
use PHPUnit\Framework\TestCase;

class CalculationsTest extends TestCase
{
    public function testGetters(): void
    {
        $token = (new Token())
            ->setValue('abcde');

        $calculator = (new Calculator())
            ->setToken($token)
            ->setCreatedAt(\DateTimeImmutable::createFromFormat(DATE_W3C, '2023-04-04T00:00:00+00:00'));

        $calculations = (new Calculations())
            ->setCalculator($calculator)
            ->setExpression('2 + 2')
            ->setResult(4.0)
            ->setCreatedAt(\DateTimeImmutable::createFromFormat(DATE_W3C, '2023-04-04T00:00:00+00:00'));

        $this->assertSame($calculator, $calculations->getCalculator());
        $this->assertSame('2 + 2', $calculations->getExpression());
        $this->assertSame(4.0, $calculations->getResult());
        $this->assertSame('2023-04-04T00:00:00+00:00', $calculations->getCreatedAt()->format(DATE_W3C));
    }
}
