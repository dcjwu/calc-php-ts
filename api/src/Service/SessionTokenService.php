<?php

namespace App\Service;

use App\Entity\Token;
use App\Factory\TokenFactory;
use App\Interface\TokenServiceInterface;
use App\Repository\TokenRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Process\Exception\LogicException;

class SessionTokenService implements TokenServiceInterface
{
    public function __construct(
        private readonly TokenRepository $tokenRepository,
        private readonly TokenFactory $tokenFactory
    )
    {
    }

    public function getToken(Request $request): Token|null
    {
        $sessionId = $request->getSession()->getId();
        return $this->tokenRepository->findOneBy(['value' => $sessionId]);
    }

    public function createToken(Request $request): Token
    {
        $token = $this->getToken($request);

        if ($token) {
            throw new LogicException('Token already exists');
        }

        $session = new Session();
        $session->start();

        $newToken = $this->tokenFactory
            ->setValue($session->getId())
            ->create();

        $this->tokenRepository->save($newToken, true);

        return $newToken;
    }
}