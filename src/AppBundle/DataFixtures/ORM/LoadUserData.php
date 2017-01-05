<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use DateTime;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('dwnek');
        $user->setPlainPassword('1234');
        $user->setEmail('dwnek@caxy.com');
        $user->setJiraEmail('dwnek@caxy.com');
        $user->setDisplayName('David Wnek');
        $user->setStartDate(new DateTime());
        $user->setEnabled(true);
        $user->addRole('ROLE_ADMIN');
        
        
        $manager->persist($user);
        $manager->flush();
    }
}