<?php

namespace App\DataFixtures;

use App\Entity\Appointment;
use App\Entity\Availability;
use App\Entity\Reason;
use App\Entity\User\Patient;
use App\Entity\User\Practitioner;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AppointmentFixture.
 */
class AppointmentFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $appointment = new Appointment();

        /** @var Availability $availbality */
        $availbality = $this->getReference(Availability::class . '_' . Availability::BUSY);
        /** @var Patient $patient */
        $patient = $this->getReference(Patient::class);
        /** @var Practitioner $practitioner */
        $practitioner = $this->getReference(Practitioner::class);
        /** @var Reason $reason */
        $reason = $this->getReference(Reason::class . '_1');

        $appointment->setAvailability($availbality)
            ->setPatient($patient)
            ->setPractitioner($practitioner)
            ->setReason($reason)
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(null)
            ->setDeletedAt(null)
            ->setDescription(null)
            ->setStatus(Appointment::WAITING_PRACTITIONER_STATUS);

        $manager->persist($appointment);

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            PatientFixture::class,
            PractitionerFixture::class,
            ReasonFixture::class,
            AvailabilityFixture::class,
        ];
    }
}
