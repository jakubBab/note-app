<?php

declare(strict_types=1);

namespace App\App\Task\Infrastructure\Doctrine;

use App\App\Shared\Domain\Exception\DomainArgumentException;
use App\App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use App\App\Task\Domain\Dto\TaskDto;
use App\App\Task\Domain\Task;
use App\App\Task\Domain\TaskUser;
use App\App\Task\Infrastructure\Doctrine\Contract\TaskUserRepositoryInterface;
use App\App\User\Domain\User;

class DoctrineTaskUserRepository extends DoctrineRepository implements TaskUserRepositoryInterface
{
    protected string $entity = TaskUser::class;

    public function create(TaskDto $taskDto): void
    {
        $user = $this->entityManager()->getRepository(User::class)->find($taskDto->userId());
        if (empty($user)) {
            throw new DomainArgumentException('user not found');
        }
        $task = new Task();
        $task->setUuid($taskDto->uuid())
            ->setDescription($taskDto->description());

        /** @var TaskUser $taskUser */
        $taskUser = $this->entity();
        $taskUser->setUser($user)
            ->setTask($task);

        $this->persist($taskUser);
    }

    public function findTodayTasksByUserId(string $userUuid): ?array
    {
        $user = $this->entityManager()->getRepository(User::class)->findOneBy([
            'uuid' => $userUuid,
        ]);

        if (empty($user)) {
            throw new DomainArgumentException('user not found');
        }

        $todayAtMidnight = (new \DateTime('now'))->modify('today midnight');

        $qb = $this->entityManager()->createQueryBuilder();
        $tasks = $qb->select('task_user')
            ->from(TaskUser::class, 'task_user')
            ->andWhere('task_user.user = :user')->setParameter('user', $user)
            ->join('task_user.task', 'task')
            ->andWhere('task.createdAt > :created_at')->setParameter('created_at', $todayAtMidnight)
            ->getQuery()->getResult();

        return $this->transferToDto($tasks);
    }

    public function findByUserUuidAndTaskUuid(string $userUuid, string $taskUuid): ?TaskDto
    {
        $user = $this->entityManager()->getRepository(User::class)->findOneBy([
            'uuid' => $userUuid,
        ]);

        if (empty($user)) {
            throw new DomainArgumentException('user not found');
        }

        $qb = $this->entityManager()->createQueryBuilder();
        $tasks = $qb->select('task_user')
            ->from(TaskUser::class, 'task_user')
            ->andWhere('task_user.user = :user')->setParameter('user', $user)
            ->join('task_user.task', 'task')
            ->andWhere('task.uuid = :taskUuid')->setParameter('taskUuid', $taskUuid)
            ->getQuery()->getResult();

        $transferred = $this->transferToDto($tasks);
        return empty($transferred) ? null : $transferred[0];
    }

    private function transferToDto(array $tasks): array
    {
        $tasksDtoStorage = [];
        /** @var TaskUser $task */
        foreach ($tasks as $task) {
            $tasksDtoStorage[] = new TaskDto(
                $task->getTask()->getUuid(),
                $task->getTask()->getDescription(),
                $task->getUser()->getId(),
                $task->getTask()->isCompleted()
            );
        }

        return $tasksDtoStorage;
    }
}
