<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Patient;

class PatientFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $patient = new Patient();
        $patient->setGender('male');
        $patient->setFirstname('John');
        $patient->setLastname('Doe');
        $patient->setBirthdate(new \DateTime('-50 years'));
        $patient->setEmail('john@mail.com');

        $patient2 = new Patient();
        $patient2->setGender('female');
        $patient2->setFirstname('Sarah');
        $patient2->setLastname('Connor');
        $patient2->setBirthdate(new \DateTime('-40 years'));
        $patient2->setEmail('sarah@mail.com');

        $manager->persist($patient);
        $manager->persist($patient2);
        $manager->flush();
    }
}
