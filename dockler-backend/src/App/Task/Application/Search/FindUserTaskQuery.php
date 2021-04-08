<?php

declare(strict_types=1);

namespace App\App\Task\Application\Search;

class FindUserTaskQuery
{
    private string $userUuid;

    private string $taskUuid;

    public function __construct(string $userUuid, string $taskUuid)
    {
        $this->userUuid = $userUuid;
        $this->taskUuid = $taskUuid;
    }

    public function userUuid(): string
    {
        return $this->userUuid;
    }

    public function taskUuid(): string
    {
        return $this->taskUuid;
    }
}
