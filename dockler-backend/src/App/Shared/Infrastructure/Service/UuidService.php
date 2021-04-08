<?php

declare(strict_types=1);

namespace App\App\Shared\Infrastructure\Service;

use Ramsey\Uuid\Uuid;

class UuidService
{
    public function __invoke(): string
    {
        return Uuid::uuid4()->toString();
    }
}
