<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setPlainPassword('1234');
        $user->setEmail('user@caxy.com');
        $user->setEnabled(true);
        $user->addRole('ROLE_USER');
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPlainPassword('1234');
        $admin->setEmail('admin@caxy.com');
        $admin->setEnabled(true);
        $admin->addRole('ROLE_ADMIN');
        $admin->addRole('ROLE_SONATA_ADMIN');
        $manager->persist($admin);

        $superAdmin = new User();
        $superAdmin->setUsername('superadmin');
        $superAdmin->setPlainPassword('1234');
        $superAdmin->setEmail('superadmin@caxy.com');
        $superAdmin->setEnabled(true);
        $superAdmin->addRole('ROLE_SUPER_ADMIN');
        $admin->addRole('ROLE_SONATA_ADMIN');
        $manager->persist($superAdmin);

        $manager->flush();
    }
}
