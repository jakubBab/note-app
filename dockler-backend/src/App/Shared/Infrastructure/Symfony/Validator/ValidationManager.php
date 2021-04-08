<?php

declare(strict_types=1);

namespace App\App\Shared\Infrastructure\Symfony\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationManager
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    private $violations;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(Constraint $constraints, array $dataToValidate): void
    {
        $this->violations = $this->validator->validate($dataToValidate, $constraints);
    }

    public function isValid(): bool
    {
        return $this->violations === null;
    }

    public function getViolations(): array
    {
        $errorFormat = [];

        /** @var ConstraintViolation $constraintViolation */
        foreach ($this->violations as $constraintViolation) {
            $errorFormat[] = $this->getViolation($constraintViolation);
        }

        return $errorFormat;
    }

    private function getViolation(ConstraintViolation $constraintViolation): array
    {
        $errorFormat = [];

        $errorFormat['message'] = $constraintViolation->getMessage();
        $errorFormat['path'] = $this->normalizePropertyPath(
            $constraintViolation->getPropertyPath()
        );
        $errorFormat['invalid_value'] = $constraintViolation->getInvalidValue();

        return $errorFormat;
    }

    private function normalizePropertyPath(string $propertyPath)
    {
        $regex = '/[^[]+=?(?=\])[^\]]?/';
        preg_match_all($regex, $propertyPath, $matches);
        $matches = $matches[0];

        return count($matches) > 1 ? $matches[1] : $matches[0];
    }
}
