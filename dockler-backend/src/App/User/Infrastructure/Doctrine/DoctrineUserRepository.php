<?php

namespace App\App\User\Infrastructure\Doctrine;

use App\App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use App\App\User\Domain\User;
use App\App\User\Domain\UserRepositoryInterface;

class DoctrineUserRepository extends DoctrineRepository implements UserRepositoryInterface
{
    protected string $entity = User::class;
}
