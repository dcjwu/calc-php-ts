<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Token;

class TokenFactory
{
    private Token $token;

    public function __construct()
    {
        $this->token = new Token();
    }

    public function setValue(string $tokenValue): TokenFactory
    {
        $this->token->setValue($tokenValue);

        return $this;
    }

    public function create(): Token
    {
        return $this->token;
    }
}
