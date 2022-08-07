<?php

namespace App\Entity;

use App\Entity\User\Patient;
use App\Entity\User\Practitioner;
use App\Repository\AppointmentRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Appointment
{
    public const CONFIRMED_PRACTITIONER_STATUS = 'CONFIRMED_PRACTITIONER';

    public const WAITING_PRACTITIONER_STATUS = 'WAITING_PRACTITIONER';

    public const CANCELLED_PRACTITIONER_STATUS = 'CANCELLED_PRACTITIONER';

    public const MODIFIED_PRACTITIONER_STATUS = 'MODIFIED_PRACTITIONER';

    public const CANCELLED_PATIENT_STATUS = 'CANCELLED_PATIENT';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string",
     *     length=255,
     *     columnDefinition="ENUM('CONFIRMED_PRACTITIONER','WAITING_PRACTITIONER','CANCELLED_PRACTITIONER','MODIFIED_PRACTITIONER','CANCELLED_PATIENT')"
     * )
     */
    private string $status;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Practitioner::class, inversedBy="appointments", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Practitioner $practitioner;

    /**
     * @var Patient
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="appointments")
     * @ORM\JoinColumn(nullable=false)
     */
    private Patient $patient;

    /**
     * @var Reason|null
     * @ORM\OneToOne(targetEntity=Reason::class, cascade={"persist", "remove"})
     */
    private ?Reason $reason;

    /**
     * @ORM\OneToOne(targetEntity=Availability::class, inversedBy="appointment", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Availability $availability;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->createdAt = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return $this
     */
    public function setUpdatedAt(?DateTimeInterface $updated_at): self
    {
        $this->updatedAt = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    /**
     * @return $this
     */
    public function setDeletedAt(?DateTimeInterface $deleted_at): self
    {
        $this->deletedAt = $deleted_at;

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

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    /**
     * @return $this
     */
    public function setPatient(Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getReason(): ?Reason
    {
        return $this->reason;
    }

    /**
     * @return $this
     */
    public function setReason(?Reason $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getAvailability(): ?Availability
    {
        return $this->availability;
    }

    /**
     * @return $this
     */
    public function setAvailability(Availability $availability): self
    {
        $this->availability = $availability;

        return $this;
    }
}
