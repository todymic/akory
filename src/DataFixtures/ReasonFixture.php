<?php

namespace App\DataFixtures;

use App\Entity\Reason;
use App\Entity\Speciality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReasonFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var Speciality $speciality */
        $speciality = $this->getReference(Speciality::class);

        for ($i = 0; $i < 50; ++$i) {
            $reason = new Reason();
            $reason->setDescription('consultation');
            $reason->setConstant('consultation');
            $reason->setCategory($speciality);

            $manager->persist($reason);

            $this->addReference(Reason::class . '_' . $i, $reason);
        }

        $manager->flush();
    }

    /**
     * @return mixed
     */
    public function getDependencies()
    {
        return [
            SpecialityFixture::class,
        ];
    }
}
