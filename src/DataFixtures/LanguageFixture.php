<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class LanguageFixture.
 */
class LanguageFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $language = new Language();
        $language->setValue('fr');

        $this->addReference(Language::class, $language);
        $manager->persist($language);

        $manager->flush();
    }
}
