<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace App\Tests\Service;

use App\Entity\Token;
use App\Factory\TokenFactory;
use App\Repository\TokenRepository;
use App\Service\SessionTokenService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Process\Exception\LogicException;

class SessionTokenServiceTest extends TestCase
{
    private TokenRepository $tokenRepository;
    private TokenFactory $tokenFactory;
    private SessionTokenService $tokenService;
    private Token $token;
    private Session $session;
    private Request $request;

    protected function setUp(): void
    {
        $this->tokenRepository = $this->createMock(TokenRepository::class);
        $this->tokenFactory = $this->createMock(TokenFactory::class);

        $this->request = $this->createStub(Request::class);
        $this->session = $this->createStub(Session::class);

        $this->tokenService = new SessionTokenService(
            $this->tokenRepository,
            $this->tokenFactory
        );

        $this->token = (new Token())
            ->setValue('abcdef');
    }

    public function testGetToken()
    {
        $this->request
            ->method('getSession')
            ->willReturn($this->session);

        $this->session
            ->method('getId')
            ->willReturn('1234');

        $this->tokenRepository
            ->expects(static::once())
            ->method('findOneBy')
            ->with(['value' => '1234'])
            ->willReturn($this->token);

        $this->assertEquals(
            $this->token,
            $this->tokenService->getToken($this->request)
        );
    }

    public function testGetTokenReturnsNull()
    {
        $this->request
            ->method('getSession')
            ->willReturn($this->session);

        $this->session
            ->method('getId')
            ->willReturn('');

        $this->tokenRepository
            ->expects(static::once())
            ->method('findOneBy')
            ->with(['value' => ''])
            ->willReturn(null);

        $this->assertEquals(
            null,
            $this->tokenService->getToken($this->request)
        );
    }

    public function testCreateToken()
    {
        $this->request
            ->method('getSession')
            ->willReturn($this->session);

        $this->session
            ->method('getId')
            ->willReturn('');

        $this->tokenRepository
            ->expects(static::once())
            ->method('findOneBy')
            ->with(['value' => ''])
            ->willReturn(null);

        $this->tokenFactory
            ->expects(static::once())
            ->method('setValue');

        $this->tokenRepository
            ->expects(static::once())
            ->method('save');

        $this->tokenService->createToken($this->request);
    }

    public function testCreateTokenThrowsException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Token already exists');

        $this->request
            ->method('getSession')
            ->willReturn($this->session);

        $this->session
            ->method('getId')
            ->willReturn('1234');

        $this->tokenRepository
            ->expects(static::once())
            ->method('findOneBy')
            ->with(['value' => '1234'])
            ->willReturn($this->token);

        $this->tokenService->createToken($this->request);
    }
}
