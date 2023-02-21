<?php

declare(strict_types=1);

namespace App\tests\Unit\Factory;

use App\Entity\Token;
use App\Factory\CalculatorFactory;
use PHPUnit\Framework\TestCase;

class CalculatorFactoryTest extends TestCase
{
    public function testCreateCalculator()
    {
        $token = (new Token())
            ->setValue('abcde');

        $calculator = (new CalculatorFactory())
            ->setToken($token)
            ->setCreatedAt()
            ->create();

        $this->assertSame($token, $calculator->getToken());
    }
}
