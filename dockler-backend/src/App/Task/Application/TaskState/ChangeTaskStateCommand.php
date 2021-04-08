<?php

declare(strict_types=1);

namespace App\App\Task\Application\TaskState;

class ChangeTaskStateCommand
{
    private string $taskUuid;

    private string $userUuid;

    private bool $completed;

    public function __construct(string $taskUuid, string $userUuid, bool $completed = false)
    {
        $this->taskUuid = $taskUuid;
        $this->userUuid = $userUuid;
        $this->completed = $completed;
    }

    public function taskUuid(): string
    {
        return $this->taskUuid;
    }

    public function userUuid(): string
    {
        return $this->userUuid;
    }

    public function completed(): bool
    {
        return $this->completed;
    }
}
