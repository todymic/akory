<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User\Patient;
use App\Tests\DatabaseToolTrait;
use App\Tests\EntityManagerToolTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientTest extends KernelTestCase
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

    public function testAddNewPatient(): void
    {
        $this->loadFixtures(
            [
                'App\DataFixtures\PatientFixture',
            ]
        );

        /** @var Patient $patient */
        $patient = $this->entityManager->getRepository(Patient::class)->findOneBy(
            [
                'id' => 1,
            ]
        );

        $this->assertInstanceOf(Patient::class, $patient);
        $this->assertContains('ROLE_PATIENT', $patient->getRoles());
        $this->assertEquals('M', $patient->getGender());
        $this->assertEquals('Mr', $patient->getCivility());
    }
}
