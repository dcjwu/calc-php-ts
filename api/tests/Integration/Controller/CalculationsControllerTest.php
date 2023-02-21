<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;
use App\Entity\Token;
use App\Entity\Calculator;
use App\Entity\Calculations;

class CalculationsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ?EntityManagerInterface $em;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createClient();
        $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }

    public function testGetCalculations()
    {
        $session = $this->createSession($this->client, 'abcde');

        $token = (new Token())
            ->setValue($session->getId());
        $this->em->persist($token);

        $calculator = (new Calculator())
            ->setToken($token)
            ->setCreatedAt(\DateTimeImmutable::createFromFormat(DATE_W3C, '2023-04-04T00:00:00+00:00'));
        $this->em->persist($calculator);

        $calculations = (new Calculations())
            ->setCalculator($calculator)
            ->setExpression('2 + 2')
            ->setResult('4')
            ->setCreatedAt(\DateTimeImmutable::createFromFormat(DATE_W3C, '2023-04-04T00:00:00+00:00'));
        $this->em->persist($calculations);

        $this->em->flush();

        $this->client->request('GET', '/api/calculations');
        $this->assertResponseIsSuccessful();

        $res = json_encode([[
            'calculatorId' => $calculator->getId(),
            'id' => $calculations->getId(),
            'expression' => $calculations->getExpression(),
            'result' => $calculations->getResult()
        ]]);

        $this->assertEquals(
            $res,
            $this->client->getResponse()->getContent()
        );

//        fwrite(STDERR, print_r($this->client->getResponse()->getContent(), TRUE));
    }

    public function testGetCalculationsThrows401()
    {
        $this->client->request('GET', '/api/calculations');
        $this->assertResponseStatusCodeSame(401);
    }

    public function testSetCalculations()
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/calculations',
            content: json_encode([
                'expression' => '2 + 2',
                'result' => '4'
            ])
        );

        $res = $this->client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertEquals($res, json_encode([
            'expression' => '2 + 2',
            'result' => '4'
        ]));
    }

    public function createSession(KernelBrowser $client, string $sessionId): Session
    {
        $container = $client->getContainer();
        $sessionSavePath = $container->getParameter('session.save_path');
        $sessionStorage = new MockFileSessionStorage($sessionSavePath);

        $session = new Session($sessionStorage);
        $session->setId($sessionId);
        $session->start();

        $sessionCookie = new Cookie(
            $session->getName(),
            $session->getId(),
            null,
            null,
            'localhost',
        );
        $client->getCookieJar()->set($sessionCookie);

        return $session;
    }
}