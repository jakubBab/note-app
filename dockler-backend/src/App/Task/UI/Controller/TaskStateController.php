<?php

declare(strict_types=1);

namespace App\App\Task\UI\Controller;

use App\App\Shared\Domain\Event\TaskStateChangedEvent;
use App\App\Shared\UI\Controller\DocklerAbstractController;
use App\App\Task\Application\TaskState\ChangeTaskStateCommand;
use App\App\Task\UI\Validation\TaskStateConstraints;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskStateController extends DocklerAbstractController
{
    public function changeTaskState(Request $request): Response
    {
        $validateResponse = $this->validate(
            $request,
            new TaskStateConstraints()
        );

        if ($validateResponse instanceof Response) {
            return $validateResponse;
        }

        $data = $this->payload();
        $processed = $this->processCommand(new ChangeTaskStateCommand($data['taskUuid'], $this->getUser()->getUuid(), $data['completed']));

        if ($processed instanceof Response) {
            return $processed;
        }

        $this->dispatchEvent(new TaskStateChangedEvent($data['taskUuid'], $data['completed']));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
