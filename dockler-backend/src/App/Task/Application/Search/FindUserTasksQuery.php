<?php

declare(strict_types=1);

namespace App\App\Task\Application\Search;

class FindUserTasksQuery
{
    public string $userUuid;

    public function __construct(string $userUuid)
    {
        $this->userUuid = $userUuid;
    }

    public function userUuid(): string
    {
        return $this->userUuid;
    }
}
