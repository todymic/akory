<?php

namespace App\Entity;

use App\Entity\User\Practitioner;
use App\Repository\AvailabilityRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvailabilityRepository::class)
 */
class Availability
{
    public const OPEN = 'OPEN';
    public const BUSY = 'BUSY';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $day;

    /**
     * @ORM\Column(type="time")
     */
    private ?DateTimeInterface $hour;

    /**
     * @ORM\Column(type="string", length=255, columnDefinition="ENUM('OPEN','BUSY')")
     */
    private ?string $status;

    /**
     * @ORM\ManyToOne(targetEntity=Practitioner::class, inversedBy="availabilities", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Practitioner $practitioner;

    /**
     * @ORM\OneToOne(targetEntity=Appointment::class, mappedBy="availability", cascade={"persist", "remove"})
     */
    private ?Appointment $appointment;

    /**
     * @ORM\ManyToOne(targetEntity=Locality::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Locality $locality;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?DateTimeInterface
    {
        return $this->day;
    }

    /**
     * @return $this
     */
    public function setDay(DateTimeInterface $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getHour(): ?DateTimeInterface
    {
        return $this->hour;
    }

    /**
     * @return $this
     */
    public function setHour(DateTimeInterface $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPractitioner(): ?Practitioner
    {
        return $this->practitioner;
    }

    /**
     * @return $this
     */
    public function setPractitioner(?Practitioner $practitioner): self
    {
        $this->practitioner = $practitioner;

        return $this;
    }

    public function getAppointment(): ?Appointment
    {
        return $this->appointment;
    }

    /**
     * @return $this
     */
    public function setAppointment(Appointment $appointment): self
    {
        // set the owning side of the relation if necessary
        if ($appointment->getAvailability() !== $this) {
            $appointment->setAvailability($this);
        }

        $this->appointment = $appointment;

        return $this;
    }

    public function getLocality(): ?Locality
    {
        return $this->locality;
    }

    /**
     * @return $this
     */
    public function setLocality(?Locality $locality): self
    {
        $this->locality = $locality;

        return $this;
    }
}
