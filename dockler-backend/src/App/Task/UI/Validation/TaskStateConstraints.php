<?php

declare(strict_types=1);

namespace App\App\Task\UI\Validation;

use App\App\Shared\Infrastructure\Symfony\Validator\ValidationConstraintsInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

class TaskStateConstraints implements ValidationConstraintsInterface
{
    public function getConstraints(): Constraint
    {
        $constraints = [
            'completed' => [
                new Assert\NotNull(),
                new Assert\Type('bool'),
            ],
            'taskUuid' => [
                new Assert\Regex([
                    'pattern' => '/^[A-Za-z\d-]*$/',
                ]),
            ],
        ];

        return new Assert\Collection($constraints);
    }
}
