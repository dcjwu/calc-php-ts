<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Calculator;
use App\Entity\Token;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testGetters(): void
    {
        $token = (new Token())
            ->setValue('abcde');

        $calculator = (new Calculator())
            ->setToken($token)
            ->setCreatedAt(\DateTimeImmutable::createFromFormat(DATE_W3C, '2023-04-04T00:00:00+00:00'));

        $this->assertSame($token, $calculator->getToken());
        $this->assertSame('2023-04-04T00:00:00+00:00', $calculator->getCreatedAt()->format(DATE_W3C));
    }
}
