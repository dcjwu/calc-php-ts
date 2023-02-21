<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace App\tests\Unit\Validator;

use App\Dto\CalculationsRequestDto;
use App\Exceptions\PayloadValidationException;
use App\Validator\RequestBodyValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestBodyValidatorTest extends TestCase
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private RequestBodyValidator $requestBodyValidator;
    private Request $request;

    protected function setUp(): void
    {
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);

        $this->requestBodyValidator = new RequestBodyValidator(
            $this->serializer,
            $this->validator
        );

        $this->request = $this->createStub(Request::class);
    }

    public function testValidate()
    {
        $dto = (new CalculationsRequestDto())
            ->setExpression('1 + 1')
            ->setResult(3.0);

        $this->serializer
            ->expects($this->once())
            ->method('deserialize')
            ->with($this->request->getContent(), CalculationsRequestDto::class, 'json')
            ->willReturn($dto);

        $violationList = (new ConstraintViolationList());

        $this->validator
            ->expects($this->once())
            ->method('validate')
            ->with($dto)
            ->willReturn($violationList);

        $this->assertEquals(
            $dto,
            $this->requestBodyValidator->validate($this->request, CalculationsRequestDto::class)
        );
    }

    public function testValidateThrowsPayloadValidationException()
    {
        $this->expectException(PayloadValidationException::class);
        $this->expectExceptionMessage('test-error');

        $dto = (new CalculationsRequestDto())
            ->setExpression('1 + 1')
            ->setResult(3);

        $this->serializer
            ->expects($this->once())
            ->method('deserialize')
            ->with($this->request->getContent(), CalculationsRequestDto::class, 'json')
            ->willReturn($dto);

        $violationList = (new ConstraintViolationList())::createFromMessage('test-error');

        $this->validator
            ->expects($this->once())
            ->method('validate')
            ->with($dto)
            ->willReturn($violationList);

        $this->requestBodyValidator->validate($this->request, CalculationsRequestDto::class);
    }
}
