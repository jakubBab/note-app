<?php

declare(strict_types=1);

namespace App\App\Task\Infrastructure\Doctrine\Contract;

use App\App\Task\Domain\Task;

interface TaskRepositoryInterface
{
    public function save(Task $task): void;

    public function findByUuid(string $uuid): ?Task;

    public function changeTaskState(bool $completed, string $taskUuid): void;
}
