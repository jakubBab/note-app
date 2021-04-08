<?php
declare(strict_types=1);


namespace App\App\Shared\Domain\Event;


class TaskStateChangedEvent
{
    private string $taskUuid;
    private bool $completed;

    public function __construct(string $taskUuid, bool $completed)
    {
        $this->taskUuid = $taskUuid;
        $this->completed = $completed;
    }

    public function taskUuid(): string
    {
        return $this->taskUuid;
    }

    public function setTaskUuid(string $taskUuid): void
    {
        $this->taskUuid = $taskUuid;
    }

    public function completed(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }

}