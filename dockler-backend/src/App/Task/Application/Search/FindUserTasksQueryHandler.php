<?php

declare(strict_types=1);

namespace App\App\Task\Application\Search;

use App\App\Shared\Infrastructure\Symfony\MessageBus\Contract\QueryBusInterface;
use App\App\Task\Infrastructure\Doctrine\DoctrineTaskUserRepository;

class FindUserTasksQueryHandler implements QueryBusInterface
{
    private DoctrineTaskUserRepository $taskUserRepository;

    public function __construct(DoctrineTaskUserRepository $taskUserRepository)
    {
        $this->taskUserRepository = $taskUserRepository;
    }

    public function __invoke(FindUserTasksQuery $findUserTasksQuery): ?array
    {
        return $this->taskUserRepository->findTodayTasksByUserId($findUserTasksQuery->userUuid());
    }
}
