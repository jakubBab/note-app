<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\App\Shared\Infrastructure\Service\UuidService;
use App\App\User\Domain\Role;
use App\App\User\Domain\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    public const ADMIN_USER_REFERENCE = 'admin-user';

    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $userAdmin = new User();

        $userAdmin->setEmail('user@dockler.com');
        $userAdmin->setFirstName('Johny');
        $userAdmin->setLastName('Brav');
        $userAdmin->setUuid((new UuidService())->__invoke());
        $userAdmin->setPassword($this->encoder->hashPassword(
            $userAdmin,
            'Johny123@!#'
        ));

        $role = new Role();
        $role->setName('ROLE_USER');
        $userAdmin->addRole($role);

        $role = new Role();
        $role->setName('ROLE_ADMIN');
        $userAdmin->addRole($role);

        $userAdmin->setEnabled(true);

        $manager->persist($userAdmin);
        $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);
    }

    public function getOrder()
    {
        return 1;
    }
}
