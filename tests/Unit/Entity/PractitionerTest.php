<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Appointment;
use App\Entity\Availability;
use App\Entity\Language;
use App\Entity\location;
use App\Entity\Speciality;
use App\Entity\User\Practitioner;
use App\Tests\DatabaseToolTrait;
use App\Tests\EntityManagerToolTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class PractitionerTest.
 */
class PractitionerTest extends KernelTestCase
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

    public function testNewPractitioner(): void
    {
        $this->loadFixtures(
            [
                'App\DataFixtures\PractitionerFixture',
            ]
        );

        /** @var Practitioner $practitioner */
        $practitioner = $this->entityManager->getRepository(Practitioner::class)->findOneBy(
            [
                'id' => 1,
            ]
        );

        $this->assertInstanceOf(Practitioner::class, $practitioner);
        $this->assertContains('ROLE_PRACTITIONER', $practitioner->getRoles());

        $this->specialityTest($practitioner);
        $this->locationTest($practitioner);
        $this->availableTest($practitioner);
        //$this->appointementTest($practitioner);
    }

    protected function specialityTest(Practitioner $practitioner)
    {
        /** @var Speciality $speciality */
        $speciality = $practitioner->getSpecialities()->first();
        $this->assertInstanceOf(Speciality::class, $speciality);
        $this->assertEquals('Gynecologue', $speciality->getTitle());

        $practitioner->removeSpeciality($speciality);
        $this->assertEmpty($practitioner->getSpecialities());
    }

    private function locationTest(Practitioner $practitioner)
    {
        /** @var location $location */
        $location = $practitioner->getLocations()->first();
        $this->assertInstanceOf(location::class, $location);

        $practitioner->removelocation($location);
        $this->assertEmpty($practitioner->getLocations());
    }

    private function availableTest(Practitioner $practitioner)
    {
        /** @var Availability $available */
        $available = $practitioner->getAvailabilities()->first();
        $this->assertInstanceOf(Availability::class, $available);

        $practitioner->removeAvailability($available);
        $this->assertEmpty($practitioner->getAvailabilities());
    }

    private function appointementTest(Practitioner $practitioner)
    {
        /** @var Appointment $appointement */
        $appointement = $practitioner->getAppointments()->first();
        $this->assertInstanceOf(Appointment::class, $appointement);

        $practitioner->removeAppointment($appointement);
        $this->assertEmpty($practitioner->getAppointments());
    }
}
