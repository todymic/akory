<?php

namespace App\Entity\User;


use App\Entity\Appointment;
use App\Entity\Availability;
use App\Entity\Degree;
use App\Entity\Language;
use App\Entity\Locality;
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
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;
    /**
     * @ORM\ManyToMany(targetEntity=Language::class, inversedBy="practitioners")
     * @ORM\JoinTable(name="practitioners_languages",
     *      joinColumns={@ORM\JoinColumn(name="practitioner_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="language_id", referencedColumnName="id")}
     *  )
     */
    private Collection $languages;

    /**
     * @ORM\ManyToMany(targetEntity=Speciality::class, mappedBy="practitioners")
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
     * @ORM\OneToMany(targetEntity=Locality::class,
     *     mappedBy="practitioner",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     */
    private Collection $localities;

    /**
     * @ORM\OneToMany(targetEntity=Degree::class,
     *     mappedBy="practitioner",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     *  )
     */
    private Collection $degrees;

    /**
     * Practitioner constructor.
     */
    public function __construct()
    {
        $this->roles[] = 'ROLE_PRACTITIONER';
        $this->languages = new ArrayCollection();
        $this->specialities = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->availabilities = new ArrayCollection();
        $this->localities = new ArrayCollection();
        $this->degrees = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    /**
     * @return $this
     */
    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeLanguage(Language $language): self
    {
        $this->languages->removeElement($language);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    /**
     * @return $this
     */
    public function addSpeciality(Speciality $speciality): self
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities[] = $speciality;
            $speciality->addPractitioner($this);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeSpeciality(Speciality $speciality): self
    {
        if ($this->specialities->removeElement($speciality)) {
            $speciality->removePractitioner($this);
        }

        return $this;
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
     * @return Collection
     */
    public function getLocalities(): Collection
    {
        return $this->localities;
    }

    /**
     * @return $this
     */
    public function addLocality(Locality $locality): self
    {
        if (!$this->localities->contains($locality)) {
            $this->localities[] = $locality;
            $locality->setPractitioner($this);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeLocality(Locality $locality): self
    {
        if ($this->localities->removeElement($locality)) {
            // set the owning side to null (unless already changed)
            if ($locality->getPractitioner() === $this) {
                $locality->setPractitioner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getDegrees(): Collection
    {
        return $this->degrees;
    }

    /**
     * @return $this
     */
    public function addDegree(Degree $degree): self
    {
        if (!$this->degrees->contains($degree)) {
            $this->degrees[] = $degree;
            $degree->setPractitioner($this);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeDegree(Degree $degree): self
    {
        if ($this->degrees->removeElement($degree)) {
            // set the owning side to null (unless already changed)
            if ($degree->getPractitioner() === $this) {
                $degree->setPractitioner(null);
            }
        }

        return $this;
    }
}
