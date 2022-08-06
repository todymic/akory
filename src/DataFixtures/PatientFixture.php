<?php

namespace App\DataFixtures;

use App\Entity\User\Patient;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PatientFixture extends UserFixture
{
    public function load(ObjectManager $manager)
    {
        /** @var $fake */
        $fake = Faker\Factory::create();
        $patient = new Patient();

        $patient->setFirstName($fake->name());
        $patient->setLastName($fake->name());
        $patient->setEmail($fake->email);
        $patient->setPassword($this->passwordEncoder->hashPassword($patient, 'test'));
        $patient->setGender('M');
        $patient->setCivility('Mr');
        $patient->setBirthday(new DateTime('2021-01-01'));
        $patient->setRoles(['ROLE_PATIENT']);

        $manager->persist($patient);

        $this->addReference(Patient::class, $patient);

        $manager->flush();
    }
}
