<?php

namespace App\Validator;

use App\Exceptions\PayloadValidationExceptionApplication;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestBodyValidator
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface  $validator
    )
    {
    }

    /**
     * @throws PayloadValidationExceptionApplication
     */
    public function validate(Request $request, string $dto): void
    {
        $request = $this->serializer->deserialize($request->getContent(), $dto, 'json');
        $errors = $this->validator->validate($request);

        if (count($errors) > 0) {
            $response = ['errors' => []];

            foreach ($errors as $err) {
                $response['errors'][] = [
                    'property' => $err->getPropertyPath(),
                    'message' => $err->getMessage(),
                ];
            }

            throw new PayloadValidationExceptionApplication(json_encode($response));
        }
    }
}