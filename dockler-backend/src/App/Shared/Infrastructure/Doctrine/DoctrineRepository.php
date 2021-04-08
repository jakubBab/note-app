<?php

declare(strict_types=1);

namespace App\App\Shared\Infrastructure\Doctrine;

use App\App\Shared\Domain\Exception\DatabaseProcessException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

abstract class DoctrineRepository
{
    protected string $entity = '';

    private EntityManagerInterface $entityManager;

    private LoggerInterface $databaseLogger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $databaseLogger)
    {
        $this->entityManager = $entityManager;
        $this->databaseLogger = $databaseLogger;
    }

    public function checkAndRestartConnection(): void
    {
        if ($this->entityManager()->getConnection()->ping() === false) {
            $this->entityManager()->getConnection()->close();
            $this->entityManager()->getConnection()->connect();
        }
    }

    public function refreshEntityManager(object $object): void
    {
        $this->entityManager()->refresh($object);
    }

    public function findById(int $id)
    {
        return $this->entityManager()->getRepository($this->entity)->find($id);
    }

    public function findOneBy(array $criteria)
    {
        return $this->entityManager()->getRepository($this->entity)->findOneBy($criteria);
    }

    public function findBy(array $criteria)
    {
        return $this->entityManager()->getRepository($this->entity)->findBy($criteria);
    }

    public function remove($entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush();
    }

    public function findAll()
    {
        return $this->entityManager()->getRepository($this->entity)->findAll();
    }

    public function entity()
    {
        return new $this->entity();
    }

    public function update(): void
    {
        $this->entityManager()->flush();
    }

    public function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function persist($entity): void
    {
        try {
            if ($entity->getId() === null) {
                $this->entityManager()->persist($entity);
            }

            $this->update();
        } catch (\Exception $exception) {
            dump($exception);
            die;
            $this->logError($exception->getMessage(), $exception);
            throw new DatabaseProcessException('Unable to save entity. Please contact administrator');
        }
    }

    protected function logError($message, $exception): void
    {
        $this->databaseLogger->error(
            '',
            [
                'payload' => $message,
                'when' => date('c'),
                'error' => $exception,
            ]
        );
    }
}
