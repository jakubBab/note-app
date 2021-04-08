<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\App\Shared\Infrastructure\Service\UuidService;
use App\App\Task\Domain\Dto\TaskDto;
use App\App\Task\Infrastructure\Doctrine\DoctrineTaskUserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements OrderedFixtureInterface
{
    private DoctrineTaskUserRepository $taskUserRepository;

    public function __construct(DoctrineTaskUserRepository $taskUserRepository)
    {
        $this->taskUserRepository = $taskUserRepository;
    }

    public function load(ObjectManager $manager)
    {
        $user = $this->getReference(UserFixtures::ADMIN_USER_REFERENCE);
        $taskDto = new TaskDto((new UuidService())->__invoke(), 'watch joker', $user->getId());

        $this->taskUserRepository->create($taskDto);
    }

    public function getOrder()
    {
        return 2;
    }
}
