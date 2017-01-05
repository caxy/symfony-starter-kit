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
        $user->setUsername('admin');
        $user->setPlainPassword('test');
        $user->setEmail('dwnek@caxy.com');
        $user->setJiraEmail('dwnek@caxy.com');
        $user->setDisplayName('David Wnek');
        $user->setStartDate(new DateTime());
        
        
        $manager->persist($user);
        $manager->flush();
    }
}