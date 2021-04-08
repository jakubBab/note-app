<?php

declare(strict_types=1);

namespace App\App\Task\Application\Create;

use App\App\Shared\Infrastructure\Symfony\MessageBus\Contract\CommandBusInterface;
use App\App\Task\Domain\Dto\TaskDto;
use App\App\Task\Infrastructure\Doctrine\DoctrineTaskUserRepository;

class CreateTaskCommandHandler implements CommandBusInterface
{
    private DoctrineTaskUserRepository $taskUserRepository;

    public function __construct(DoctrineTaskUserRepository $taskUserRepository)
    {
        $this->taskUserRepository = $taskUserRepository;
    }

    public function __invoke(CreateTaskCommand $createTaskCommand): void
    {
        $this->taskUserRepository->create(
            new TaskDto($createTaskCommand->uuid(), $createTaskCommand->description(), $createTaskCommand->userId())
        );
    }
}
