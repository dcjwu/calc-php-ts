<?php

declare(strict_types=1);

namespace App\tests\Unit\Factory;

use App\Factory\TokenFactory;
use PHPUnit\Framework\TestCase;

class TokenFactoryTest extends TestCase
{
    public function testCreateToken()
    {
        $token = (new TokenFactory())
            ->setValue('abcde')
            ->create();

        $this->assertSame('abcde', $token->getValue());
    }
}
