<?php

declare(strict_types=1);

namespace App\App\Task\UI\Controller;

use App\App\Shared\UI\Controller\DocklerAbstractController;
use App\App\Task\Application\Search\FindUserTaskQuery;
use App\App\Task\Application\Search\FindUserTasksQuery;
use Symfony\Component\HttpFoundation\Response;

class SearchTaskController extends DocklerAbstractController
{
    public function findUserTasks(): Response
    {
        return $this->processQuery(
            new FindUserTasksQuery($this->getUser()->getUuid()),
            ['task']
        );
    }

    public function findByUuid(string $taskUuid): Response
    {
        return $this->processQuery(
            new FindUserTaskQuery($this->getUser()->getUuid(), $taskUuid),
            ['task']
        );
    }
}
