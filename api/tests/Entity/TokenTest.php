<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Token;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
    public function testGetters()
    {
        $token = (new Token())
            ->setValue('abcde');

        $this->assertSame('abcde', $token->getValue());
    }
}
