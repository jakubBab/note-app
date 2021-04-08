<?php

declare(strict_types=1);

namespace App\App\Task\Application\TaskState;

use App\App\Shared\Domain\Exception\DomainArgumentException;
use App\App\Shared\Infrastructure\Symfony\MessageBus\Contract\CommandBusInterface;
use App\App\Task\Domain\Dto\TaskDto;
use App\App\Task\Infrastructure\Doctrine\DoctrineTaskRepository;
use App\App\Task\Infrastructure\Doctrine\DoctrineTaskUserRepository;

class ChangeTaskStateCommandHandler implements CommandBusInterface
{
    private DoctrineTaskUserRepository $taskUserRepository;

    private DoctrineTaskRepository $taskRepository;

    public function __construct(DoctrineTaskUserRepository $taskUserRepository, DoctrineTaskRepository $taskRepository)
    {
        $this->taskUserRepository = $taskUserRepository;
        $this->taskRepository = $taskRepository;
    }

    public function __invoke(ChangeTaskStateCommand $changeTaskStateCommand)
    {
        /** @var TaskDto|null $task */
        $task = $this->taskUserRepository->findByUserUuidAndTaskUuid(
            $changeTaskStateCommand->userUuid(),
            $changeTaskStateCommand->taskUuid()
        );

        if (empty($task)) {
            throw new DomainArgumentException('task not found');
        }

        $this->taskRepository->changeTaskState($changeTaskStateCommand->completed(), $task->uuid());
    }
}
