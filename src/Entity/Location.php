<?php

namespace App\Entity;

use App\Entity\User\Practitioner;
use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $streetType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $streetName;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $zipcode;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $streetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $country;

    /**
     * @ORM\ManyToMany(targetEntity=Practitioner::class, inversedBy="locations")
     * @ORM\JoinTable(name="practitioners_locations",
     *      joinColumns={@ORM\JoinColumn(name="practitioner_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="location_id", referencedColumnName="id")}
     *  )
     */
    private Collection $practitioners;

    /**
     * @ORM\OneToMany(targetEntity=Availability::class, mappedBy="locations")
     */
    private Collection $availabilities;

    public function __construct()
    {
        $this->practitioners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreetType(): ?string
    {
        return $this->streetType;
    }

    /**
     * @return $this
     */
    public function setStreetType(string $streetType): self
    {
        $this->streetType = $streetType;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    /**
     * @return $this
     */
    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    /**
     * @return $this
     */
    public function setZipcode(int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    /**
     * @return $this
     */
    public function setStreetNumber(int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return $this
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return $this
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Practitioner>
     */
    public function getPractitioners(): Collection
    {
        return $this->practitioners;
    }

    public function addPractitioner(Practitioner $practitioner): self
    {
        if (!$this->practitioners->contains($practitioner)) {
            $this->practitioners->add($practitioner);
        }

        return $this;
    }

    public function removePractitioner(Practitioner $practitioner): self
    {
        $this->practitioners->removeElement($practitioner);

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
