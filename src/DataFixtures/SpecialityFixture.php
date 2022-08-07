<?php

namespace App\DataFixtures;

use App\Entity\Reason;
use App\Entity\Speciality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SpecialityFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $speciality = new Speciality();
        $speciality->setTitle('Gynecologue');
        $manager->persist($speciality);

        $this->addReference(Speciality::class, $speciality);

        $manager->flush();
    }
}
