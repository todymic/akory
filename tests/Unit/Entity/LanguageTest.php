<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Language;
use App\Tests\DatabaseToolTrait;
use App\Tests\EntityManagerToolTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LanguageTest extends KernelTestCase
{
    use DatabaseToolTrait;
    use EntityManagerToolTrait;

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->initDatabase($kernel);
        $this->initEntityManager($kernel);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManagerTearDown();
        $this->databaseTearDown();
    }

    public function testLoadLanguage(): void
    {
        $this->loadFixtures(
            [
                'App\DataFixtures\LanguageFixture',
            ]
        );

        /** @var Language[] $language */
        $language = $this->entityManager->getRepository(Language::class)->findAll();

        $this->assertInstanceOf(Language::class, $language[0]);
        $this->assertEquals(1, $language[0]->getId());
        $this->assertEquals('fr', $language[0]->getValue());
    }
}
