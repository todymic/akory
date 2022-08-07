<?php

namespace App\DataFixtures;

use App\Entity\Availability;
use App\Entity\Language;
use App\Entity\Location;
use App\Entity\Speciality;
use App\Entity\User\Practitioner;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

/**
 * Class PractitionerFixture.
 */
class PractitionerFixture extends UserFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var $fake */
        $fake = Faker\Factory::create();
        $partitionner = new Practitioner();

        $partitionner->setFirstName($fake->name());
        $partitionner->setLastName($fake->name());
        $partitionner->setEmail($fake->email);
        $partitionner->setPassword($this->passwordEncoder->hashPassword($partitionner, 'test'));
        $partitionner->setRoles(['ROLE_PRACTITIONER']);

        $partitionner->setDescription('Je suis professionnel');

        /** @var Language $language */
        $language = $this->getReference(Language::class);
        $partitionner->addLanguage($language);

        /** @var Speciality $speciality */
        $speciality = $this->getReference(Speciality::class);
        $partitionner->addSpeciality($speciality);

        $location = new Location();
        $location->setName("Clinique Avo");
        $location->setStreetType($fake->streetSuffix);
        $location->setStreetName($fake->streetName);
        $location->setStreetNumber($fake->randomDigit);
        $location->setCity($fake->city);
        $location->setCountry($fake->country);
        $location->setZipcode((int)$fake->postcode);

        $partitionner->addLocation($location);

        $availability = new Availability();
        $availability->setStatus(Availability::BUSY);
        $availability->setDay($fake->dateTimeBetween('now', '+1 month'));
        $availability->setHour($fake->dateTimeBetween('now', '+1 month'));
        $availability->setLocation($location);

        $partitionner->addAvailability($availability);

        $manager->persist($partitionner);

        $this->addReference(Practitioner::class, $partitionner);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LanguageFixture::class,
            SpecialityFixture::class
        ];
    }
}
