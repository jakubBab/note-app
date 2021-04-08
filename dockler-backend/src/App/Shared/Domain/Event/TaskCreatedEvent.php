<?php

declare(strict_types=1);

namespace App\App\Shared\Domain\Event;

class TaskCreatedEvent
{
    private string $taskUuid;

    public function __construct(string $taskUuid)
    {
        $this->taskUuid = $taskUuid;
    }

    public function taskUuid(): string
    {
        return $this->taskUuid;
    }
}
