<?php

declare(strict_types=1);

namespace App\App\Task\Domain\Dto;

use JMS\Serializer\Annotation\Groups;

class TaskDto
{
    /**
     * @Groups({"task"})
     */
    private string $uuid;

    /**
     * @Groups({"task"})
     */
    private string $description;

    /**
     * @Groups({"task"})
     */
    private int $userId;

    /**
     * @Groups({"task"})
     */
    private bool $completed;

    public function __construct(
        string $uuid,
        string $description,
        int $userId,
        bool $completed = false
    ) {
        $this->uuid = $uuid;
        $this->description = $description;
        $this->userId = $userId;
        $this->completed = $completed;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function completed(): bool
    {
        return $this->completed;
    }
}
