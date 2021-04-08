<?php

declare(strict_types=1);

namespace App\App\Task\Infrastructure\Doctrine;

use App\App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use App\App\Task\Domain\Task;
use App\App\Task\Infrastructure\Doctrine\Contract\TaskRepositoryInterface;

class DoctrineTaskRepository extends DoctrineRepository implements TaskRepositoryInterface
{
    protected string $entity = Task::class;

    public function save(Task $task): void
    {
        $this->persist($task);
    }

    public function changeTaskState(bool $completed, string $taskUuid): void
    {
        $qb = $this->entityManager()->createQueryBuilder();
        $qb->update($this->entity, 'task')
            ->set('task.completed', (int) $completed)
            ->andWhere('task.uuid = :uuid')
            ->setParameter('uuid', $taskUuid)
            ->getQuery()
            ->execute();
    }

    public function findByUuid(string $uuid): ?Task
    {
        return $this->findOneBy([
            'uuid' => $uuid,
        ]);
    }
}
