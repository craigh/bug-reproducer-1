<?php

namespace App\DataFixtures;

use App\Entity\Application;
use App\Entity\Group;
use App\Entity\SpecialPerson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $specialPerson = (new SpecialPerson())
            ->setFirstName('john')
            ->setLastName('doe')
            ->setStatus('current')
            ->setAnswer(1, 'blue')
            ->setAnswer(2, 'red');
        $manager->persist($specialPerson);

        $group = (new Group())
            ->setName('group1');
        $manager->persist($group);

        $application = (new Application())
            ->setFirstName('john')
            ->setLastName('doe')
            ->setSpecialPerson($specialPerson)
            ->setHairColor('brown')
            ->addGroup($group)
            ->setAnswer(1, 'green')
            ->setAnswer(2, 'blue')
        ;
        $manager->persist($application);

        $manager->flush();
    }
}
