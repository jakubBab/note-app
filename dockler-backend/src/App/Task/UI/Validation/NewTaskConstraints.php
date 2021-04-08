<?php

declare(strict_types=1);

namespace App\App\Task\UI\Validation;

use App\App\Shared\Infrastructure\Symfony\Validator\ValidationConstraintsInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

class NewTaskConstraints implements ValidationConstraintsInterface
{
    public function getConstraints(): Constraint
    {
        $constraints = [
            'description' => [
                new Assert\NotNull(),
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ],
        ];

        return new Assert\Collection($constraints);
    }
}
