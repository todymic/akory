<?php

namespace App\DataFixtures;

use App\Entity\Availability;
use App\Entity\User\Practitioner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AvailabilityFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fake = Faker\Factory::create();

        /** @var Practitioner $practitioner */
        $practitioner = $this->getReference(Practitioner::class);

        $tab = [Availability::BUSY, Availability::OPEN];

        for ($i = 0; $i < 50; ++$i) {
            $availability = new Availability();

            shuffle($tab);
            $availability->setStatus($tab[0]);
            $availability->setDay($fake->dateTimeBetween('now', '+1 month'));
            $availability->setHour($fake->dateTimeBetween('now', '+1 month'));
            $availability->setPractitioner($practitioner);
            $availability->setLocality($practitioner->getLocalities()->first());

            $this->setReference(Availability::class . '_' . $availability->getStatus(), $availability);

            $manager->persist($availability);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PractitionerFixture::class,
        ];
    }
}
