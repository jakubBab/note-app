<?php

declare(strict_types=1);

namespace App\App\Shared\Infrastructure\Symfony\Validator;

use Symfony\Component\Validator\Constraint;

interface ValidationConstraintsInterface
{
    public function getConstraints(): Constraint;
}
