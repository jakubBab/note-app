<?php

declare(strict_types=1);

namespace App\App\Task\Application\Search;

use App\App\Shared\Infrastructure\Symfony\MessageBus\Contract\QueryBusInterface;
use App\App\Task\Infrastructure\Doctrine\DoctrineTaskUserRepository;

class FindUserTaskQueryHandler implements QueryBusInterface
{
    private DoctrineTaskUserRepository $taskUserRepository;

    public function __construct(DoctrineTaskUserRepository $taskUserRepository)
    {
        $this->taskUserRepository = $taskUserRepository;
    }

    public function __invoke(FindUserTaskQuery $findUserTaskQuery)
    {
        return $this->taskUserRepository->findByUserUuidAndTaskUuid($findUserTaskQuery->userUuid(), $findUserTaskQuery->taskUuid());
    }
}
