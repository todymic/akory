<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Appointment;
use App\Entity\Availability;
use App\Entity\Reason;
use App\Entity\User\Patient;
use App\Entity\User\Practitioner;
use App\Tests\DatabaseToolTrait;
use App\Tests\EntityManagerToolTrait;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class AppointmentTest.
 */
class AppointmentTest extends KernelTestCase
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

    public function testNewAppointment(): void
    {
        $this->loadFixtures(
            [
                'App\DataFixtures\AppointmentFixture',
            ]
        );

        /** @var Appointment $appointment */
        $appointment = $this->entityManager->getRepository(Appointment::class)->findOneBy(
            [
                'id' => 1,
            ]
        );

        $this->assertNull($appointment->getDescription());
        $this->assertInstanceOf(Patient::class, $appointment->getPatient());
        $this->assertEquals(1, $appointment->getPatient()->getId());

        $this->assertInstanceOf(Practitioner::class, $appointment->getPractitioner());
        $this->assertEquals(1, $appointment->getPractitioner()->getId());

        $this->assertInstanceOf(Reason::class, $appointment->getReason());
        $this->assertEquals('consultation', $appointment->getReason()->getDescription());
        $this->assertEquals(3, $appointment->getReason()->getId());

        $this->assertEquals(Appointment::WAITING_PRACTITIONER_STATUS, $appointment->getStatus());

        $this->assertInstanceOf(Availability::class, $appointment->getAvailability());
        $this->assertEquals(Availability::BUSY, $appointment->getAvailability()->getStatus());

        $this->assertEquals((new DateTime())->format('Y-m-d'), $appointment->getCreatedAt()->format('Y-m-d'));
        $this->assertNull($appointment->getDeletedAt());
        $this->assertNull($appointment->getUpdatedAt());
    }
}
