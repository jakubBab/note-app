<?php
declare(strict_types=1);


namespace App\App\Task\Infrastructure\Doctrine\Contract;


use App\App\Task\Domain\Dto\TaskDto;

interface TaskUserRepositoryInterface
{
    public function create(TaskDto $taskDto): void;

    public function findTodayTasksByUserId(string $userUuid): ?array;

    public function findByUserUuidAndTaskUuid(string $userUuid, string $taskUuid): ?TaskDto;

}