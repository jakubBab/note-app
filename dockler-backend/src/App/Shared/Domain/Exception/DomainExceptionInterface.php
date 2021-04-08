<?php

declare(strict_types=1);

namespace App\App\Shared\Domain\Exception;

interface DomainExceptionInterface
{
    public function errorFormat(): array;
}
