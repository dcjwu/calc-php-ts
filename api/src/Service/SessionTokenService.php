<?php

namespace App\Service;

use App\Entity\Token;
use App\Interface\TokenServiceInterface;
use App\Repository\TokenRepository;
use Symfony\Component\HttpFoundation\Request;

class SessionTokenService implements TokenServiceInterface
{
    public function __construct(
        private readonly TokenRepository $tokenRepository
    )
    {
    }

    public function getToken(Request $request): Token|null
    {
        $sessionId = $request->getSession()->getId();
        return $this->tokenRepository->findOneBy(['value' => $sessionId]);
    }
}