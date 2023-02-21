<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exceptions\PayloadValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestBodyValidator
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator
    ) {
    }

    /**
     * @throws PayloadValidationException
     */
    public function validate(Request $request, string $dto)
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

            throw new PayloadValidationException(json_encode($response));
        }

        return $request;
    }
}
