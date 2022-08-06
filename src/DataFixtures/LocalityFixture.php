<?php

namespace App\DataFixtures;

use App\Entity\Locality;
use App\Entity\User\Practitioner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class LocalityFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fake = Faker\Factory::create('fr_FR');
        /** @var Practitioner $practitioner */
        $practitioner = $this->getReference(Practitioner::class);

        for ($i = 0; $i < 50; ++$i) {
            $locality = new Locality();
            $locality->setStreetType($fake->streetSuffix);
            $locality->setStreetName($fake->streetName);
            $locality->setStreetNumber($fake->randomDigit);
            $locality->setCity($fake->city);
            $locality->setCountry($fake->country);
            $locality->setZipcode((int) $fake->postcode);
            $locality->setPractitioner($practitioner);

            $this->addReference(Locality::class . '_' . $i, $locality);

            $manager->persist($locality);
        }

        $manager->flush();
    }

    /**
     * @return mixed
     */
    public function getDependencies()
    {
        return [
            PractitionerFixture::class,
        ];
    }
}
