<?php

declare(strict_types=1);

namespace App\App\Task\Application\Create;

class CreateTaskCommand
{
    private int $userId;

    private string $uuid;

    private string $description;

    public function __construct(string $uuid, int $userId, string $description)
    {
        $this->uuid = $uuid;
        $this->userId = $userId;
        $this->description = $description;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function description(): string
    {
        return $this->description;
    }
}
