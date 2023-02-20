<?php

namespace App\Interface;

use App\Entity\Token;
use Symfony\Component\HttpFoundation\Request;

interface TokenServiceInterface
{
    public function getToken(Request $request): Token|null;

    public function createToken(Request $request): Token;
}
