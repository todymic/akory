<?php

namespace App\DataFixtures;

use App\Entity\Appointment;
use App\Entity\Availability;
use App\Entity\Degree;
use App\Entity\Language;
use App\Entity\Locality;
use App\Entity\Speciality;
use App\Entity\User\Patient;
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

        $locality = new Locality();
        $locality->setStreetType($fake->streetSuffix);
        $locality->setStreetName($fake->streetName);
        $locality->setStreetNumber($fake->randomDigit);
        $locality->setCity($fake->city);
        $locality->setCountry($fake->country);
        $locality->setZipcode((int)$fake->postcode);

        $partitionner->addLocality($locality);

        $availability = new Availability();
        $availability->setStatus(Availability::BUSY);
        $availability->setDay($fake->dateTimeBetween('now', '+1 month'));
        $availability->setHour($fake->dateTimeBetween('now', '+1 month'));
        $availability->setLocality($locality);

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
