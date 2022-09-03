<?php

namespace App\Entity\User;

use App\Entity\Appointment;
use App\Entity\User;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Patient extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('M', 'F')")
     */
    protected string $gender;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('Mr', 'Mrs', 'Ms')")
     */
    protected string $civility;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="patient")
     */
    private Collection $appointments;

    /**
     * @ORM\Column(type="date")
     */
    private ?DateTimeInterface $birthday;

    /**
     * Patient constructor.
     */
    public function __construct()
    {
        $this->roles[] = 'ROLE_PATIENT';
        $this->appointments = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    /**
     * @return $this
     */
    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setPatient($this);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getPatient() === $this) {
                $appointment->setPatient(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return $this
     */
    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCivility(): ?string
    {
        return $this->civility;
    }

    /**
     * @return $this
     */
    public function setCivility(string $civility): self
    {
        $this->civility = $civility;

        return $this;
    }

    public function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }
}
