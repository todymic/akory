<?php

namespace App\Entity;

use App\Entity\User\Practitioner;
use App\Repository\LocalityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass=LocalityRepository::class)
 */
class Locality
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

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
     * @ORM\ManyToOne(targetEntity=Practitioner::class, inversedBy="localities")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Practitioner $practitioner;

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
}
