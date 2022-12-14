<?php

namespace App\Entity\User;


use App\Entity\Appointment;
use App\Entity\Availability;
use App\Entity\Language;
use App\Entity\Location;
use App\Entity\Speciality;
use App\Entity\User;
use App\Repository\PractitionerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Practitioner.
 *
 * @ORM\Entity(repositoryClass=PractitionerRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Practitioner extends User implements PasswordAuthenticatedUserInterface, UserInterface
{
    const LANGUAGES = ['fr','en','de','lu'];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;
    /**
     * @ORM\Column(type="simple_array")
     */
    private array $languages;

    /**
     * @ORM\ManyToMany(targetEntity=Speciality::class, inversedBy="practitioners")
     * @ORM\JoinTable(name="practitioners_specialities",
     *      joinColumns={@ORM\JoinColumn(name="speciality_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="practitioner_id", referencedColumnName="id")}
     * )
     */
    private Collection $specialities;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="practitioner",
     *     cascade={"persist", "remove"})
     */
    private Collection $appointments;

    /**
     * @ORM\OneToMany(targetEntity=Availability::class, mappedBy="practitioner", orphanRemoval=true,
     *     cascade={"persist", "remove"})
     * 
     */
    private Collection $availabilities;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\ManyToMany(targetEntity=Location::class, mappedBy="practitioners")
     *
     */
    private Collection $locations;

    /**
     * Practitioner constructor.
     */
    public function __construct()
    {
        $this->roles[] = 'ROLE_PRACTITIONER';
        $this->specialities = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->availabilities = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
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
            $appointment->setPractitioner($this);
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
            if ($appointment->getPractitioner() === $this) {
                $appointment->setPractitioner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAvailabilities(): Collection
    {
        return $this->availabilities;
    }

    /**
     * @return $this
     */
    public function addAvailability(Availability $availability): self
    {
        if (!$this->availabilities->contains($availability)) {
            $this->availabilities[] = $availability;
            $availability->setPractitioner($this);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeAvailability(Availability $availability): self
    {
        if ($this->availabilities->removeElement($availability)) {
            // set the owning side to null (unless already changed)
            if ($availability->getPractitioner() === $this) {
                $availability->setPractitioner(null);
            }
        }

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

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
            $location->addPractitioner($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->removeElement($location)) {
            $location->removePractitioner($this);
        }

        return $this;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function setLanguages(array $languages): self
    {
        $this->languages = $languages;

        return $this;
    }

    /**
     * @return Collection<int, Speciality>
     */
    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    public function addSpeciality(Speciality $speciality): self
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities->add($speciality);
        }

        return $this;
    }

    public function removeSpeciality(Speciality $speciality): self
    {
        $this->specialities->removeElement($speciality);

        return $this;
    }

}
