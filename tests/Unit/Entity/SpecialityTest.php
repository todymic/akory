<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Reason;
use App\Entity\Speciality;
use App\Tests\DatabaseToolTrait;
use App\Tests\EntityManagerToolTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SpecialityTest extends KernelTestCase
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

    /** @test */
    public function loadSpeciality()
    {
        $this->loadFixtures(
            [
                'App\DataFixtures\SpecialityFixture',
            ]
        );

        /** @var Speciality $speciality */
        $speciality = $this->entityManager->getRepository(Speciality::class)->findOneBy(
            [
                'id' => 1,
            ]
        );

        $this->assertInstanceOf(Speciality::class, $speciality);
        $this->assertEquals('Gynecologue', $speciality->getTitle());
    }
}
