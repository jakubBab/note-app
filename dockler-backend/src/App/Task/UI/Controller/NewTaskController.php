<?php

declare(strict_types=1);

namespace App\App\Task\UI\Controller;

use App\App\Shared\Domain\Event\TaskCreatedEvent;
use App\App\Shared\Infrastructure\Service\UuidService;
use App\App\Shared\UI\Controller\DocklerAbstractController;
use App\App\Task\Application\Create\CreateTaskCommand;
use App\App\Task\UI\Validation\NewTaskConstraints;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewTaskController extends DocklerAbstractController
{
    public function create(Request $request)
    {
        $validateResponse = $this->validate(
            $request,
            new NewTaskConstraints()
        );

        if ($validateResponse instanceof Response) {
            return $validateResponse;
        }

        $this->payload = json_decode($request->getContent(), true);
        $data = $this->payload();
        $taskUuid = (new UuidService())->__invoke();

        $isResponse = $this->processCommand(new CreateTaskCommand(
            $taskUuid,
            $this->getUser()->getId(),
            $data['description']
        ));

        if ($isResponse instanceof Response) {
            return $isResponse;
        }

        $this->dispatchEvent(new TaskCreatedEvent($taskUuid));

        return $this->redirectToRoute('task_find', [
            'taskUuid' => $taskUuid,
        ]);
    }
}
