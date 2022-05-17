<?php

namespace App\Service;

use App\Model\Request\MappableRequestInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestModelValidator
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    /**
     * @throws \Exception
     */
    public function validate(MappableRequestInterface $mappableRequest): void
    {
        $violations = $this->validator->validate($mappableRequest);

        if (count($violations) > 0) {
            throw new \Exception(
                json_encode(array_map(
                    function (ConstraintViolation $violation) {
                        return "{$violation->getPropertyPath()}: {$violation->getMessage()}";
                    },
                    iterator_to_array($violations)
                ))
            );
        }
    }
}
